<?php

/**
 * @class Request
 */
class Request
{
	/**
	 *
	 */
	public function __construct($config=array())
	{
		foreach ($config as $key=>$value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 *
	 */
	public function getParam($name, $defaultValue=null)
	{
		if (isset($_REQUEST[$name])) {
			return $_REQUEST[$name];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function getQuery($name, $defaultValue=null)
	{
		if (isset($_GET[$name])) {
			return $_GET[$name];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function getPost($name, $defaultValue=null)
	{
		if (isset($_POST[$name])) {
			return $_POST[$name];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function getFiles()
	{

	}

	/**
	 *
	 */
	public function isPost()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	/**
	 *
	 */
	public function isGet()
	{
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}

	/**
	 *
	 */
	public function isPut()
	{
		return $_SERVER['REQUEST_METHOD'] === 'PUT';
	}

	/**
	 *
	 */
	public function isDelete()
	{
		return $_SERVER['REQUEST_METHOD'] === 'DELETE';
	}

	/**
	 *
	 */
	public function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}
}