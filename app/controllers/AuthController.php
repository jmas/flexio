<?php

/**
 *
 */
class AuthController extends Controller
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

		$request = Flexio::app()->request;

		if ($request->isPost()) {
			if (! Flexio::app()->auth->login($request->getPost('username'), $request->getPost('password'), $request->getPost('remember') ? true: false)) {
				Flexio::app()->flash->set('error', 'Not logged.');
			} else {
				Flexio::app()->redirect(Flexio::app()->defaultRoute);
			}

			Flexio::app()->redirect(array(
				'controller'=>'auth',
				'action'=>'index',
			));	
		}

		echo $this->render('index');
	}

	/**
	 *
	 */
	public function logoutAction()
	{
		Flexio::app()->auth->logout();

		Flexio::app()->redirect(array(
			'controller'=>'auth',
			'action'=>'index',
		));
	}
}