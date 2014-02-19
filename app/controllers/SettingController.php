<?php

/**
 *
 */
class SettingController extends AppController
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
        if ($this->app->request->isPost()) {
            $data = $this->app->request->getPost('data');
            var_dump($data);
        }
		echo $this->render('index');
        
	}

	/**
	 *
	 */
	public function updateAction()
	{
		echo $this->render('update');
	}
}