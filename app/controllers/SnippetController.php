<?php

/**
 *
 */
class SnippetController extends Controller
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! App::instance()->auth->isLoggedIn()) {
			App::instance()->redirect(array(
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
}