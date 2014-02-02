<?php

/**
 *
 */
class PageController extends AppController
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
	public function indexAction($path=null)
	{
		$models = $this->app->pages->findAll();

		echo $this->render('index', array(
			'models'=>$models,
		));
	}
}