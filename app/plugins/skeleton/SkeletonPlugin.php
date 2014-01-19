<?php

/**
 *
 */
class SkeletonPlugin extends Plugin
{
	/**
	 *
	 */
	protected $name='Skeleton';

	/**
	 *
	 */
	protected $version='1.0';

	/**
	 *
	 */
	public function permissions()
	{
		return array('skeleton-editor', 'skeleton-administrator', 'skeleton-developer');
	}

	/**
	 *
	 */
	public function navItems()
	{
		return array(
			array(
				'name'=>'Content',
				'items'=>array(
					array(
						'name'=>'Skeleton',
						'url'=>array(
							'plugin'=>'skeleton',
							'controller'=>'skeleton',
							'action'=>'index',
						),
					),
				),
			),
		);
	}

	/**
	 *
	 */
	public function onAppStart()
	{
		// echo $this->renderView('appStart');
	}

	/**
	 *
	 */
	public function onAppEnd()
	{
		// echo $this->renderView('appEnd');
	}
}