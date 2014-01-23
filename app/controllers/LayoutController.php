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
        
        if (Flexio::app()->request->isPost()) {
        
            if ($model->save()) {
                Flexio::app()->flash->set('success', 'Layout added successfully.');
                Flexio::app()->redirect(array('controller'=>'layout', 'action'=>'index'));
            } else {
                Flexio::app()->flash->set('error', 'Adding layout error. ' . implode(', ', $model->getErrors()));
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
        
        if (Flexio::app()->request->isPost()) {
            if ($model->update($name)) {
                Flexio::app()->flash->set('success', 'Layout updated successfully.');
                Flexio::app()->redirect(array('controller'=>'layout', 'action'=>'index'));
            } else {
                Flexio::app()->flash->set('error', 'Layout updated error. ' . implode(', ', $model->getErrors()));
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
            Flexio::app()->flash->set('success', 'Layout deleted successfully.');
            Flexio::app()->redirect(array('controller'=>'layout', 'action'=>'index'));
        } else {
            Flexio::app()->flash->set('error', 'Layout delete error. ' . implode(', ', $model->getErrors()));
        }
       
	}
}