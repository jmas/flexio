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

	}
  
	/**
	 *
	 */
	public function addAction()
	{
        if (App::instance()->request->isPost()) {
            $data = App::instance()->request->getPost('data');
            $model = App::instance()->models->create('User', $data);
            if ($model->save()) {
                 App::instance()->flash->set('success', 'User added successfully.');
                 App::instance()->redirect(array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
            } else {
                var_dump($model->getErrors());
            }
        }
        echo $this->render('add');
	}
  
	/**
	 *
	 */
	public function editAction($id=null)
	{
        $model = App::instance()->models->findByAttrs('User', array('id' => $id));

        if (App::instance()->request->isPost()) {
        
            $model->setAttrs(App::instance()->request->getPost('data'));
            if ($model->save()) {
                 App::instance()->flash->set('success', 'Saved.');
                 App::instance()->redirect(array(
                    'controller'=>'user',
                    'action'=>'edit',
                    'id'=>$id
                ));
            } else {
                var_dump($model->getErrors());
            }
        }
        
        echo $this->render('edit',
            array(
                'model'=>$model 
            )
        );
	}
  
	/**
	 *
	 */
	public function deleteAction($id)
	{	
        $model = App::instance()->models->findByAttrs('User', array('id' => $id));   
        if ($model->username !== 'admin') {
            if ($model->delete()) {
                 App::instance()->flash->set('success', 'User '. $model->username .' successfully removed.');
                 App::instance()->redirect(array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
            } else {
                var_dump($model->getErrors());
            }
        } else {
            App::instance()->flash->set('error', 'User '. $model->username .' can not be removed.');
                 App::instance()->redirect(array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
        }
	}
}