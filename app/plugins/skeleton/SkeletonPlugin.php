<?php

class SkeletonPlugin extends Plugin
{
	protected $name='Skeleton';
	protected $version='1.0';

	public function onAppStart()
	{
		echo 'app start';
	}

	public function onAppEnd()
	{
		echo 'app end';
	}
}