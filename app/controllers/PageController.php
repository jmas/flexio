<?php

/**
 *
 */
class PageController extends Controller
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! Flexio::app()->auth->isLoggedIn()) {
			Flexio::app()->redirect(array(
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
		$models = Flexio::app()->models->findAll('Page');

		echo $this->render('index', array(
			'models'=>$models,
		));
	}
}