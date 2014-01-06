<?php

class PageController extends Controller
{
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! App::instance()->auth->isLoggedIn()) {
			App::instance()->redirect(array(
				'controller'=>'auth',
				'action'=>'index',
			));
		}

		$this->setLayoutValue('isNavEnabled', true);

		return true;
	}

	public function indexAction($path=null)
	{
		//var_dump($path);
		// var_dump(App::instance()->models->find('Page'));

		// var_dump(App::instance()->models->findAll('Page'));

		// var_dump(App::instance()->models->findAllByAttrs('Page', array(
		// 	'path'=>'/myslug',
		// )));

		echo $this->render('index');
	}
}