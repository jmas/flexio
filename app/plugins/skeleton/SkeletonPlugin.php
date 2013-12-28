<?php

class SkeletonPlugin extends Plugin
{
	protected $name='Skeleton';
	protected $version='1.0';

	public function onAppStart()
	{
		echo $this->renderView('appStart');
	}

	public function onAppEnd()
	{
		echo $this->renderView('appEnd');
	}
}