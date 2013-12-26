<?php

class Plugin
{
	protected $name;
	protected $version;

	public function __construct($config=array())
	{
		foreach ($config as $key=>$value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	public function register()
	{
		$methods = get_class_methods($this);
		
		foreach ($methods as $method) {
			if (substr($method, 0, 2) === 'on') {
				$name = substr($method, 2);
				$name[0] = strtolower($name[0]);
				
				App::instance()->observer->observe($name, array($this, $method));
			}
		}
	}

	public function install() { return true; }
	public function uninstall() { return true; }
}