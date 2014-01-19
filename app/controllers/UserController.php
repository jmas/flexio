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
	public function indexAction()
	{
		$models = Flexio::app()->models->findAll('User');
		
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
    
    $model = Flexio::app()->models->create('User');

        if (Flexio::app()->request->isPost()) {
        
            $data = Flexio::app()->request->getPost('data');
            $data['permissions'] = implode(',', $data['permissions']);
            $model = Flexio::app()->models->create('User', $data);
            
            if ($model->save()) {
                Flexio::app()->flash->set('success', 'User added successfully.');
                Flexio::app()->redirect(array('controller'=>'user', 'action'=>'index'));
            } else {
                Flexio::app()->flash->set('error', 'Error... '.implode(', ', $model->getErrors()).' field is required');
            }
        }
        
        $permissions = Flexio::app()->getAllPermissions();
        
        echo $this->render('add', array(
            'model'=>$model,
            'permissions'=>$permissions,
        ));
	}
  
	/**
	 *
	 */
	public function editAction($id=null)
	{
        if ($model = Flexio::app()->models->findByAttrs('User', array('id' => $id))) {
        
            if (Flexio::app()->request->isPost()) {
                $data = Flexio::app()->request->getPost('data');
                $data['password'] = empty($data['password']) ? $model->password : $data['password'];
                $data['permissions'] = implode(',', $data['permissions']);
                $model->setAttrs($data);
                if ($model->save()) {
                    Flexio::app()->flash->set('success', 'Changes have been saved.');
                    Flexio::app()->redirect(array('controller'=>'user', 'action'=>'edit', 'id'=>$id ));
                    
                } else {
                    Flexio::app()->flash->set('error', 'Error... '.implode(', ', $model->getErrors()).' is required');
                }
            }

            $permissions = Flexio::app()->getAllPermissions();
            
            echo $this->render('edit', array(
            	'model'=>$model,
            	'permissions'=>$permissions,
        	));
            
        } else {
            throw new Exception("Profile with id '{$id}' is not exists.");
        }
	}
  
	/**
	 *
	 */
	public function deleteAction($id)
	{	
        $model = Flexio::app()->models->findByAttrs('User', array('id' => $id));   
        if ($model->username !== 'admin') {
            if ($model->delete()) {
                 Flexio::app()->flash->set('success', 'User '. $model->username .' successfully removed.');
                 Flexio::app()->redirect(array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
            } else {
                var_dump($model->getErrors());
            }
        } else {
            Flexio::app()->flash->set('error', 'User '. $model->username .' can not be removed.');
                 Flexio::app()->redirect(array(
                    'controller'=>'user',
                    'action'=>'index'
                ));
        }
	}
}