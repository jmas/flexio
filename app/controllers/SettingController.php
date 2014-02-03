<?php

/**
 *
 */
class SettingController extends AppController
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! $this->app->auth->isLoggedIn()) {
			$this->app->redirect(array(
				'controller'=>'auth',
				'action'=>'index',
			));
		}

		$this->setLayoutValue('isNavEnabled', true);

		return true;
	}

	/**
	 *
	 */
	public function indexAction()
	{
		echo $this->render('index');
	}

	/**
	 *
	 */
	public function pluginAction()
	{
        $plugins = $this->app->plugins->findAll();
        
        echo $this->render('plugin', array(
            'plugins'=>$plugins
        ));
	}
    /**
	 *
	 */
	public function addPluginAction()
	{

        $localPlugins = $this->app->plugins->findAll();
        foreach ($localPlugins as $plugin) {
            $pluginList[] = strtolower($plugin->getName());
        }

        $plugins = $this->app->plugins->findAllRemote();
        
        foreach ($plugins as $key => $plugin) {
            if(in_array(strtolower($plugin['name']), $pluginList)) {
            //unset($plugins[$key]); //remove already installed on the system plugins from output list
            }
        }
        
        echo $this->render('addPlugin', array(
            'plugins'=>$plugins,
        ));
	}

	/**
	 *
	 */
	public function downloadPluginAction($remoteUrl)
	{
        $data = $this->app->plugins->findRemote($remoteUrl);
        var_dump($data);
        $curl = curl_init();
        $options = array( 
            CURLOPT_URL     => $data['url'],
            CURLOPT_RETURNTRANSFER =>  1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
         );
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);
        
        $filename = $data['name'] . '.zip';
        
        file_put_contents($filename, $content);

        $archiver = new Archiver();
        $archiver->unpack(realpath($filename), PLUGINS_PATH . DIRECTORY_SEPARATOR);
        rename(PLUGINS_PATH . DIRECTORY_SEPARATOR . $data['name'] . '-flexio-plugin-master', PLUGINS_PATH . DIRECTORY_SEPARATOR . basename($data['name'], '-flexio-plugin-master'));
        unlink(realpath($filename)); 
        $this->app->flash->set('success', 'Downloaded successfully.');
        $this->app->redirect(array('setting','plugin'));
        
	}

	/**
	 *
	 */
	public function installAction($pluginName)
	{
        if ($this->app->plugins->install($pluginName)) {
	        $this->app->flash->set('success', 'Installed successfully.');
	    } else {
	    	$this->app->flash->set('error', 'Installation is failed.');
	    }

        $this->app->redirect(array('setting','plugin'));
	}

	/**
	 *
	 */
	public function uninstallAction($pluginName)
	{
		if ($this->app->plugins->uninstall($pluginName)) {
	        $this->app->flash->set('success', 'Uninstalled successfully.');
	    } else {
	    	$this->app->flash->set('error', 'Uninstallation is failed.');
	    }

        $this->app->redirect(array('setting','plugin'));
	}

	/**
	 *
	 */
	public function updateAction()
	{
		echo $this->render('update');
	}
}