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
		echo $this->render('plugin');
	}

	/**
	 *
	 */
	public function updateAction()
	{
		echo $this->render('update');
	}
}