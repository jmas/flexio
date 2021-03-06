<?php

/**
 *
 */
class AuthController extends AppController
{
	/**
	 *
	 */
	public function indexAction()
	{
		$this->setLayoutValue('css', array(
			'http://getbootstrap.com/examples/signin/signin.css',
		));

		$this->setLayoutValue('isNavEnabled', false);

		$request = $this->app->request;

		if ($request->isPost()) {
			if (! $this->app->auth->login($request->getPost('username'), $request->getPost('password'), $request->getPost('remember') ? true: false)) {
				$this->app->flash->set('error', 'Not logged.');
			} else {
				$this->app->redirect($this->app->defaultRoute);
			}

			$this->redirect(array('index'));	
		}

		echo $this->render('index');
	}

	/**
	 *
	 */
	public function logoutAction()
	{
		$this->app->auth->logout();

		$this->redirect(array('index'));
	}
}