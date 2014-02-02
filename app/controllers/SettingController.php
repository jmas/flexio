<?php

/**
 *
 */
class SettingController extends Controller
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

        if ($this->app->request->isGet()) {
        
            if ($data = $this->app->request->getQuery('install')) {
                $this->app->plugins->install($data);
                $this->app->redirect(array('setting','plugin'));
            }
            else if ($data = $this->app->request->getQuery('uninstall')) {
                $this->app->plugins->uninstall($data);
                $this->app->redirect(array('setting','plugin'));
            }
        }
        
        echo $this->render('plugin', array(
            'plugins'=>$plugins
        ));
	}

	/**
	 *
	 */
	public function updateAction()
	{
		echo $this->render('update');
	}
}