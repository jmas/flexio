<?php

/**
 *
 */
class SkeletonController extends PluginController
{
	/**
	 *
	 */
	public function indexAction()
	{
		echo $this->render('index');
	}
}