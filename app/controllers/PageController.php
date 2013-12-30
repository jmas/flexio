<?php

class PageController extends Controller
{
	public function beforeExec($actionName)
	{
		if ($actionName !== 'index') { // && not auth
			throw new Exception("Not authentificated.");
		}

		return true;
	}

	public function indexAction($path=null)
	{
		var_dump($path);
		// var_dump(App::instance()->models->find('Page'));

		// var_dump(App::instance()->models->findAll('Page'));

		// var_dump(App::instance()->models->findAllByAttrs('Page', array(
		// 	'path'=>'/myslug',
		// )));

		echo $this->render('index');
	}
}