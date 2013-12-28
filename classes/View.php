<?php

class View
{
	/**
	 *
	 */
	protected $values=array();

	/**
	 *
	 */
	protected $path;

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
	public function __get($key)
	{
		return $this->getValue($key);
	}

	/**
	 *
	 */
	public function __toString()
	{
		return $this->render();
	}

	/**
	 *
	 */
	public function setValues($values=array())
	{
		$this->values=$values;
	}

	/**
	 *
	 */
	public function setValue($key, $value)
	{
		$this->values[$key]=$value;
	}

	/**
	 *
	 */
	public function getValue($key, $defaultValue=null)
	{
		if (isset($this->values[$key])) {
			return $this->values[$key];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function render()
	{
		if (! is_file($this->path)) {
			throw new Exception("View '{$this->path}' not found.");
		}

		ob_start();
		
		require($this->path);
		
		$result = ob_get_contents();
		ob_end_clean();
		
		return $result;
	}
}