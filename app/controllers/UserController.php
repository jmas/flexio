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
		echo $this->render('index', 
			array(
				'models' => $models
			) 
		);

		// $model = App::instance()->models->create('User', array(
		// 	'name'=>'myname',
		// 	'username'=>'myusername',
		// 	'password'=>'mypassword',
		// 	'email'=>'myemail@email.com',
		// ));

		// if ($model->save()) {
		// 	echo('saved');
		// } else {
		// 	var_dump($model->getErrors());
		// }
	}

	/**
	 *
	 */
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