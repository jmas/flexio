<?php

class PageManager extends ModelManager
{
	/**
	 *
	 */
	public function findAll($args=array(), $values=array())
	{
		return parent::findAll('Page', $args, $values);
	}

	/**
	 *
	 */
	public function findBySlug()
	{

	}

	/**
	 *
	 */
	public function findByPath()
	{

	}

	/**
	 *
	 */
	public function findChildrenOf(Page $model)
	{

	}
}