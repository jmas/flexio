<?php

class PageController extends Controller
{
	public function indexAction()
	{
		// var_dump(App::instance()->models->find('Page'));

		// var_dump(App::instance()->models->findAll('Page'));

		// var_dump(App::instance()->models->findAllByAttrs('Page', array(
		// 	'path'=>'/myslug',
		// )));

		echo $this->render('index');
	}
}