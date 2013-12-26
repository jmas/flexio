<?php

class Loader
{
	/**
	 *
	 */
	protected $paths=array();

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
	public function register()
	{
		spl_autoload_register(array($this, 'autoload'));
	}

	public function addPath($path)
	{
		$this->paths[] = $path;
	}

	/**
	 *
	 */
	public function autoload($className)
	{
		foreach ($this->paths as $path) {
			$filePath = $path . DIRECTORY_SEPARATOR . $className . '.php';

			if (file_exists($filePath)) {
				require_once($filePath);
				return true;
			}
		}

		throw new Exception("Class '{$className}' not found.");
	}
}