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