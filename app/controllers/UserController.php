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
    
    $model = App::instance()->models->create('User');

        if (App::instance()->request->isPost()) {
        
            $data = App::instance()->request->getPost('data');
            $data['permissions'] = implode(',', $data['permissions']);
            $model = App::instance()->models->create('User', $data);
            
            if ($model->save()) {
                App::instance()->flash->set('success', 'User added successfully.');
                App::instance()->redirect(array('controller'=>'user', 'action'=>'index'));
            } else {
                App::instance()->flash->set('error', 'Error... '.implode(', ', $model->getErrors()).' field is required');
            }
        }
        
        echo $this->render('add', array('model'=>$model));
	}
  
	/**
	 *
	 */
	public function editAction($id=null)
	{
        if ($model = App::instance()->models->findByAttrs('User', array('id' => $id))) {
        
            if (App::instance()->request->isPost()) {
                $data = App::instance()->request->getPost('data');
                $data['password'] = empty($data['password']) ? $model->password : $data['password'];
                $data['permissions'] = implode(',', $data['permissions']);
                $model->setAttrs($data);
                if ($model->save()) {
                    App::instance()->flash->set('success', 'Changes have been saved.');
                    App::instance()->redirect(array('controller'=>'user', 'action'=>'edit', 'id'=>$id ));
                    
                } else {
                    App::instance()->flash->set('error', 'Error... '.implode(', ', $model->getErrors()).' is required');
                }
            }
            
            echo $this->render('edit', array('model'=>$model));
            
        } else {
            throw new Exception("Profile with id '{$id}' is not exists.");
        }
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