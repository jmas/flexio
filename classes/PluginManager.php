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

		$className = ucfirst($pluginName) . 'Plugin';

		$pluginPath = PLUGINS_PATH . DIRECTORY_SEPARATOR . $pluginName . DIRECTORY_SEPARATOR . ucfirst($pluginName) . 'Plugin.php';

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

		return file_put_contents($configPath, $content) !== false;
	}

	/**
	 *
	 */
	public function getAllPermissions()
	{
		if (empty($this->permissions)) {
			$permissions=array();

			foreach ($this->registered as $plugin) {
				$permissions=array_merge($permissions, $plugin->permissions());
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

		return file_put_contents($configPath, $content) !== false;
	}

	/**
	 *
	 */
	public function findAll()
	{
		$plugins = glob(PLUGINS_PATH . DIRECTORY_SEPARATOR . '*');

		$items = array();

		foreach ($plugins as $path) {
			if (! is_dir($path)) {
				continue;
			}

			$name = basename($path);

			$items[] = $this->get($name);
		}

		return $items;
	}
}