<?php

/**
 *
 */
class LayoutController extends Controller
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
        $model = new Layout;
		echo $this->render('index', array(
                'layouts'=>$model->getLayouts(),
            ));
	}
    
    /**
	 *
	 */
	public function addAction()
	{

        $model = new Layout;
        
        if ($this->app->request->isPost()) {
        
            if ($model->save()) {
                $this->app->flash->set('success', 'Layout added successfully.');
                $this->app->redirect(array('controller'=>'layout', 'action'=>'index'));
            } else {
                $this->app->flash->set('error', 'Adding layout error. ' . implode(', ', $model->getErrors()));
            }
        }
        
        echo $this->render('form', array(
            'model'=>$model,
        ));
        
	}
    
    /**
	 *
	 */
    public function editAction($name)
	{   
        $model = new Layout;
        
        if (!$content = $model->getLayout($name)) {
            throw new Exception("File '{$name}' is not exists in layout dir.");
        } 
        
        if ($this->app->request->isPost()) {
            if ($model->update($name)) {
                $this->app->flash->set('success', 'Layout updated successfully.');
                $this->app->redirect(array('controller'=>'layout', 'action'=>'index'));
            } else {
                $this->app->flash->set('error', 'Layout updated error. ' . implode(', ', $model->getErrors()));
            }
            
        }
        
        echo $this->render('form', array(
            'name'=>$name,
            'content'=>$content
         ));
	}
    
    
    /**
	 *
	 */
    public function deleteAction($name)
	{   
        $model = new Layout;
        
        if ($model->delete($name)) {
            $this->app->flash->set('success', 'Layout deleted successfully.');
            $this->app->redirect(array('controller'=>'layout', 'action'=>'index'));
        } else {
            $this->app->flash->set('error', 'Layout delete error. ' . implode(', ', $model->getErrors()));
        }
       
	}
}