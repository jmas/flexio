<?php

class Observer
{
	/**
	 *
	 */
	protected $observers = array();

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
	public function observe($name, $callback)
	{
		if (! isset(self::$observers[$name])) {
			$this->observers[$name] = array();
		}

		$this->observers[$name][] = $callback;
	}

	/**
	 *
	 */
	public function notify($name, $args=array())
	{
		if (isset($this->observers[$name])) {
			foreach ($this->observers[$name] as $observer) {
				call_user_func_array($observer, $args);
			}
		}
	}
}