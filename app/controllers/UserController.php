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
			Flexio::app()->redirect(array('auth','index'));
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
		
		echo $this->render('index', array(
            'models'=>$models,
		));
	}
  
	/**
	 *
	 */
	public function addAction()
	{
        $model = Flexio::app()->models->create('User');

        if (Flexio::app()->request->isPost()) {
            $data = Flexio::app()->request->getPost('data');
            $model->setAttrs($data);

            if ($model->save()) {
                Flexio::app()->flash->set('success', 'Saved successfully.');
                Flexio::app()->redirect(array('user','index'));
            } else {
                Flexio::app()->flash->set('error', 'Not saved. Fields have errors.');
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
	public function editAction($id)
	{
        $model = Flexio::app()->models->findById('User', $id);

        if ($model === null) {
            Flexio::app()->flash->set('error', 'Record with this id not found in DB.');
            Flexio::app()->redirect(array('user', 'index'));
        }

        if (Flexio::app()->request->isPost()) {
            $data = Flexio::app()->request->getPost('data');
            
            $model->setAttrs($data);

            if ($model->save()) {
                Flexio::app()->flash->set('success', 'Saved successfully.');
                Flexio::app()->redirect(array('user','edit','id'=>$id));
            } else {
                Flexio::app()->flash->set('error', 'Not saved. Fields have errors.');
            }
        }

        $permissions = Flexio::app()->getAllPermissions();
        
        echo $this->render('edit', array(
        	'model'=>$model,
        	'permissions'=>$permissions,
    	));
	}
  
	/**
	 *
	 */
	public function deleteAction($id)
	{	
        $model = Flexio::app()->models->findById('User', $id);

        if ($model === null) {
            Flexio::app()->flash->set('error', 'Record with this id not found in DB.');
            Flexio::app()->redirect(array('user','index'));
        }

        if ($model->username === 'admin') {
            Flexio::app()->flash->set('error', 'Not removed. User with username \'admin\' can\'t be removed.');
            Flexio::app()->redirect(array('user','index'));
        }

        if ($model->delete()) {
            Flexio::app()->flash->set('success', 'Removed successfully.');
            Flexio::app()->redirect(array('user','index'));
        } else {
            Flexio::app()->flash->set('error', 'Not removed.');
            Flexio::app()->redirect(array('user','index'));
        }
	}
}