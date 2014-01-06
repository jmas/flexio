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

		$request = App::instance()->request;

		if ($request->isPost()) {
			if (! App::instance()->auth->login($request->getPost('username'), $request->getPost('password'), $request->getPost('remember') ? true: false)) {
				App::instance()->flash->set('error', 'Not logged.');
			} else {
				App::instance()->redirect(App::instance()->defaultRoute);
			}

			App::instance()->redirect(array(
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
		App::instance()->auth->logout();

		App::instance()->redirect(array(
			'controller'=>'auth',
			'action'=>'index',
		));
	}
}