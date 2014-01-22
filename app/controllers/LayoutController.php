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
        $layouts = glob(LAYOUTS_PATH . DIRECTORY_SEPARATOR . '*.php');
		echo $this->render('index', array(
                'layouts'=>$layouts,
            ));
	}
    	/**
	 *
	 */
	public function addAction()
	{
        $model = Flexio::app()->models->findAll('User');
        
        echo $this->render('form', array(
        'model'=>$model,
        ));
	}
}