<?php

class PluginsController extends AppController
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! $this->app->auth->isLoggedIn()) {
			$this->redirect(array('index'));
		}

		$this->setLayoutValue('isNavEnabled', true);

		return true;
	}

	/**
	 *
	 */
	public function indexAction()
	{
		$plugins = $this->app->plugins->findAll();

	 	echo $this->render('index', array(
            'plugins'=>$plugins
        ));
	}

	/**
	 *
	 */
	public function addAction()
	{
		$plugins = $this->app->plugins->findAllRemote();
        
        echo $this->render('add', array(
            'plugins'=>$plugins,
        ));
	}

	/**
	 *
	 */
	public function downloadAction($name)
	{
		$url = $this->app->plugins->getRemoteZipUrlByName($name);

		if ($this->app->plugins->download($name)) {
			$this->app->flash->set('success', 'Downloaded successfully.');
		} else {
			$this->app->flash->set('error', 'Download is failed.');
		}

        $this->redirect(array('index'));
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

        $this->redirect(array('index'));
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

        $this->redirect(array('index'));
	}
}