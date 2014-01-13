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

		$model = App::instance()->models->create('User', array(
			'name'=>'myname',
			'username'=>'myusername',
			'password'=>'mypassword',
			'email'=>'myemail@email.com',
		));

		// if ($model->save()) {
		// 	echo('saved');
		// } else {
		// 	var_dump($model->getErrors());
		// }
	}
  
	/**
	 *
	 */
	public function addAction()
	{
		echo $this->render('add');
        
        $request = App::instance()->request;
        if ($request->isPost()) {

        $model = App::instance()->models->create('User', array(
			'name'=>'myname',
			'username'=>'myusername',
			'password'=>'mypassword',
			'email'=>'myemail@email.com',
		));
        
        }
	}
  
	/**
	 *
	 */
	public function editAction($id=null)
	{
        $model = App::instance()->models->find('User', $id);
        
        echo $this->render('edit',
            array(
                'model'=>$model 
            )
        );
        
        $request = App::instance()->request;
        
        if ($request->isPost()) {
            App::instance()->flash->set('success', 'Saved.');
            App::instance()->redirect(array(
				'controller'=>'user',
				'action'=>'edit',
				'id'=>$id
			));	
        }
	}
  
	/**
	 *
	 */
	public function deleteAction($id)
	{	
        App::instance()->flash->set('success', 'User with id '. $id .' successfully removed.');
            App::instance()->redirect(array(
				'controller'=>'user',
				'action'=>'index',
			));
	}
}