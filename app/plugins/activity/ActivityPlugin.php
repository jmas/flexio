<?php

/**
 *
 */
class ActivityPlugin extends Plugin
{
	/**
	 *
	 */
	protected $name='Activity';

	/**
	 *
	 */
	protected $version='1.0';

	/**
	 *
	 */
	public function navItems()
	{
		return array(
			array(
				'name'=>'Activity',
				'url'=>array(
					'plugin'=>'activity',
					'controller'=>'activity',
					'action'=>'index',
				),
			),
		);
	}
}