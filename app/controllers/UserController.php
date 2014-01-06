<?php

/**
 *
 */
class UserController extends Controller
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
		$models = App::instance()->models->findAll('User');
		var_dump($models[0]->getPermissions());
		echo $this->render('index', 
			array(
				'models' => $models
			) 
		);
	}
	public function deleteAction($id)
	{	
		echo 'Delete ' . $id;
	}

	/**
	 *
	 */
	public function profileAction($id=null)
	{
		echo $this->render('profile');
	}
}