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
			$this->app->redirect(array('auth', 'index'));
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
        
        $this->addEditorAssets();

        if ($this->app->request->isPost()) {
            $data = $this->app->request->getPost('data');
            
            $model->setAttrs($data);
            
            if ($model->save()) {
                $this->app->flash->set('success', 'Saved successfully.');
                $this->redirect(array('index'));
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

        $this->addEditorAssets();

        if ($model === null) {
            $this->app->flash->set('error', 'Record with this id not found in DB.');
            $this->redirect(array('index'));
        }

        if ($this->app->request->isPost()) {
            $data = $this->app->request->getPost('data');
            
            $model->setAttrs($data);
            
            if ($model->save()) {
                $this->app->flash->set('success', 'Saved successfully.');
                $this->redirect(array('edit', 'id'=>$id));
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
            $this->redirect(array('index'));
        }

        if ($model->delete()) {
            $this->app->flash->set('success', 'Removed successfully.');
            $this->redirect(array('index'));
        } else {
            $this->app->flash->set('error', 'Not removed.');
            $this->redirect(array('index'));
        }
	}
}