<?php

/**
 * @class Page
 */
class Page extends Model
{
	/**
	 *
	 */
	public function children()
	{

	}

	/**
	 *
	 */
	public function parent()
	{

	}

	/**
	 *
	 */
	public function content()
	{

	}

	/**
	 *
	 */
	public function breadcrumbs()
	{

	}

	/**
	 *
	 */
	public function root()
	{

	}

	/**
	 *
	 */
	public function findByPath($path)
	{
		return $this->manager->findByPath($path);
	}

	/**
	 *
	 */
	public function findBySlug($slug)
	{
		return $this->manager->findBySlug($slug);
	}
}