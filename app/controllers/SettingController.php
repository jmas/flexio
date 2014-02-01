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
        $plugins = glob(PLUGINS_PATH . DIRECTORY_SEPARATOR . '*');

        if ($this->app->request->isGet()) {
        
            if ($data = $this->app->request->getQuery('install')) {
                $this->app->plugins->install($data);
            }
            else if ($data = $this->app->request->getQuery('uninstall')) {
                $this->app->plugins->uninstall($data);
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