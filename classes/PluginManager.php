<?php

/**
 * @class PluginManager
 */
class PluginManager
{
	/**
	 *
	 */
	protected $installed=array();

	/**
	 *
	 */
	protected $registered=array();

	/**
	 *
	 */
	protected $permissions=array();

	/**
	 *
	 */
	protected $app;


	/**
	 *
	 */
	protected $remoteGithubUser = 'jmas';

	/**
	 *
	 */
	protected $remoteGithubRepo = 'flexio-plugins';

	/**
	 *
	 */
	public function __construct($config=array())
	{
		foreach ($config as $key=>$value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 *
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 *
	 */
	public function registerInstalled(array $config=array())
	{
		foreach ($this->installed as $pluginName) {
			$this->registered[$pluginName] = $this->registerPlugin($pluginName, $config);
		}
	}

	/**
	 *
	 */
	public function registerPlugin($pluginName, array $config=array())
	{
		$instance = $this->get($pluginName);
		$instance->register();

		return $instance;
	}

	/**
	 *
	 */
	public function isInstalled($pluginName)
	{
		return in_array($pluginName, $this->installed);
	}

	/**
	 *
	 */
	public function get($pluginName)
	{
		if (isset($this->registered[$pluginName])) {
			return $this->registered[$pluginName];
		}
		
		$className = ucfirst(preg_replace_callback('/\-([a-z])/', function($p) {
			return ucfirst($p[1]);
		}, $pluginName)) . 'Plugin';

		$pluginPath = PLUGINS_PATH . DIRECTORY_SEPARATOR . $pluginName . DIRECTORY_SEPARATOR . $className . '.php';

		if (! file_exists($pluginPath)) {
			throw new Exception("Plugin file '{$pluginPath}' not found.");
		}

		require_once($pluginPath);

		if (! class_exists($className)) {
			throw new Exception("Plugin class '{$className}' not exists.");
		}

		$config['app'] = $this->app;

		$instance = new $className($config);

		return $instance;
	}

	/**
	 *
	 */
	public function install($pluginName)
	{
		if ($this->isInstalled($pluginName)) {
			return true;
		}

		$plugin = $this->registerPlugin($pluginName);
		
		if (! $plugin->beforeInstall()) {
			return false;
		}

		$installed = $this->installed;
		$installed[] = $pluginName;

		$configPath = APP_PATH . DIRECTORY_SEPARATOR . PLUGINS_CONFIG_FILE_NAME;

		if (! file_exists($configPath)) {
			throw new Exception("Plugins config '{$configPath}' not found.");
		}

		$config = require($configPath);

		$config['installed'] = $installed;
		
		$content = '<?php return ' . var_export($config, true) . ';';

		$result = file_put_contents($configPath, $content) !== false ? true: false;

		if ($result === true) {
			$this->installed = $installed;
		}

		return $result;
	}

	/**
	 *
	 */
	public function getAllPermissions()
	{
		if (empty($this->permissions)) {
			$permissions=array();

			foreach ($this->registered as $plugin) {
				$perms = $plugin->permissions();

				if (is_array($perms)) {
					$permissions=array_merge($permissions, $perms);
				}
			}

			$this->permissions=array_unique($permissions);
		}

		return $this->permissions;
	}

	/**
	 *
	 */
	public function uninstall($pluginName)
	{
		if (! $this->isInstalled($pluginName)) {
			return true;
		}

		$plugin = $this->get($pluginName);

		if (! $plugin->beforeUninstall()) {
			return false;
		}

		$installed = array();

		foreach ($this->installed as $name) {
			if ($name !== $pluginName) {
				$installed[] = $name;
			}
		}

		$configPath = APP_PATH . DIRECTORY_SEPARATOR . PLUGINS_CONFIG_FILE_NAME;

		if (! file_exists($configPath)) {
			throw new Exception("Plugins config '{$configPath}' not found.");
		}

		$config = require($configPath);

		$config['installed'] = $installed;

		$content = '<?php return ' . var_export($config, true) . ';';

		$result = file_put_contents($configPath, $content) !== false ? true: false;

		if ($result === true) {
			$this->installed = $installed;
		}

		return $result;
	}

	/**
	 *
	 */
	public function findAll()
	{
		$plugins = $this->findAllNames();

		$items = array();

		foreach ($plugins as $name) {
			$items[] = $this->get($name);
		}

		return $items;
	}

	/**
	 *
	 */
	public function findAllNames()
	{
		$plugins = glob(PLUGINS_PATH . DIRECTORY_SEPARATOR . '*');

		$items = array();

		foreach ($plugins as $path) {
			if (! is_dir($path)) {
				continue;
			}

			$name = basename($path);

			$items[] = $name;
		}

		return $items;
	}
    
    /**
	 *
	 */
	public function findAllRemote($isLocalExcepted=true)
	{
		$localPlugins = $this->findAllNames();

        $apiContentsUrl = 'https://api.github.com/repos/' . $this->remoteGithubUser . '/' . $this->remoteGithubRepo . '/contents';

        $curl = curl_init();
        $options = array(
            CURLOPT_URL            => $apiContentsUrl,
            CURLOPT_RETURNTRANSFER =>  1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
        );
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($content, true);

        $items = array();
        
        foreach ($data as $item) {
        	if (strstr($item['name'], '-flexio-plugin')) {
        		$name = basename($item['name'], '-flexio-plugin');

        		if ($isLocalExcepted && in_array($name, $localPlugins)) {
        			continue;
        		}

        		$items[] = array(
        			'name'=>$name,
        			'sha'=>$item['sha'],
        			'url'=>$item['url'],
    			);
        	}
        }
        
        return $items;
	}
    
	/**
	 *
	 */
    public function findRemote($apiContentsUrl)
	{
        $curl = curl_init();

        $options = array(
            CURLOPT_URL            => $apiContentsUrl,
            CURLOPT_RETURNTRANSFER =>  1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
        );
        curl_setopt_array($curl, $options);

        $content = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($content, true);

        //https://codeload.github.com/jmas/skeleton-flexio-plugin/zip/master
        $item = array(
            'name' => basename($data['name'], '-flexio-plugin'),
            'sha' => $data['sha'],
            'url' => str_replace('.git', '/archive/master.zip', $data['submodule_git_url']),
            
        );

        return $item;
	}

	/**
	 *
	 */
	public function getRemoteZipUrlByName($name)
	{
		$apiUrl = 'https://api.github.com/repos/' . $this->remoteGithubUser . '/' . $this->remoteGithubRepo . '/contents/' . $name . '-flexio-plugin?ref=master';

		$curl = curl_init();
        $options = array( 
            CURLOPT_URL     => $apiUrl,
            CURLOPT_RETURNTRANSFER =>  1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
         );
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($content, true);

        if (! isset($data['submodule_git_url'])) {
        	throw new Exception("Plugin with name '{$name}' not exists.");
        }

        $pluginRepoUrl = $data['submodule_git_url'];

        $pluginRepoUrl = preg_replace('/\.git$/', '', $data['submodule_git_url']);

        // https://github.com/jmas/activity-flexio-plugin.git
        // https://github.com/jmas/activity-flexio-plugin/archive/master.zip

        $url = $pluginRepoUrl . '/archive/master.zip';

        return $url;
	}

	/**
	 *
	 */
	public function download($name)
	{
		$url = $this->getRemoteZipUrlByName($name);

		$curl = curl_init();
        $options = array( 
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER =>  1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
         );
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);

        $targetFilePath = PLUGINS_PATH . DIRECTORY_SEPARATOR . $name . '-plugin-temp.zip';

        file_put_contents($targetFilePath, $content);

        if (! $this->app->archiver->unpack($targetFilePath, PLUGINS_PATH . DIRECTORY_SEPARATOR)) {
        	return false;
        }

        rename(PLUGINS_PATH . DIRECTORY_SEPARATOR . $name . '-flexio-plugin-master', PLUGINS_PATH . DIRECTORY_SEPARATOR . $name);
        
        unlink(realpath($targetFilePath));

        return true;
	}
}