<?php

/**
 *
 */
class LayoutController extends AppController
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
	public function indexAction()
	{
        
        $models = $this->app->models->findAll('Layout');
		echo $this->render('index', array(
                'models'=>$models,
            ));
	}
    
    /**
	 *
	 */
	public function addAction()
	{
        $model = $this->app->models->create('Layout');
        
        if ($this->app->request->isPost()) {
            $data = $this->app->request->getPost('data');
            
            $model->setAttrs($data);
            
            if ($model->save()) {
                $this->app->flash->set('success', 'Saved successfully.');
                $this->app->redirect(array('layout','index'));
            }
        }

         echo $this->render('form', array(
            'model'=>$model,
        ));
        
	}
    
    /**
	 *
	 */
    public function editAction($id)
	{   
        $model = $this->app->models->findById('Layout', $id);

        if ($model === null) {
            $this->app->flash->set('error', 'Record with this id not found in DB.');
            $this->app->redirect(array('user', 'index'));
        }

        if ($this->app->request->isPost()) {
            $data = $this->app->request->getPost('data');
            
            $model->setAttrs($data);
            
            if ($model->save()) {
                $this->app->flash->set('success', 'Saved successfully.');
                $this->app->redirect(array('layout', 'edit', 'id'=>$id));
            }
        }

        echo $this->render('form', array(
        	'model'=>$model
    	));
	}
    
    
    /**
	 *
	 */
    public function deleteAction($id)
	{   
        $model = $this->app->models->findById('Layout', $id);

        if ($model === null) {
            $this->app->flash->set('error', 'Record with this id not found in DB.');
            $this->app->redirect(array('layout', 'index'));
        }

        if ($model->delete()) {
            $this->app->flash->set('success', 'Removed successfully.');
            $this->app->redirect(array('layout', 'index'));
        } else {
            $this->app->flash->set('error', 'Not removed.');
            $this->app->redirect(array('layout', 'index'));
        }
       
	}
}