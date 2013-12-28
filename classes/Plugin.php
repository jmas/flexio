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

		$modelsPath = $this->getPath() . DIRECTORY_SEPARATOR . 'models';

		if (is_dir($modelsPath)) {
			App::instance()->loader->addPath($modelsPath);
		}
	}

	public function beforeInstall() { return true; }
	public function beforeUninstall() { return true; }

	/**
	 *
	 */
	public function getId()
	{
		return lcfirst(basename(get_class($this), 'Plugin'));
	}

	/**
	 *
	 */
	public function getPath()
	{
		return PLUGINS_PATH . DIRECTORY_SEPARATOR . $this->getId();
	}

	/**
	 *
	 */
	public function renderView($viewName, array $values=array())
	{
		$viewPath = $this->getPath() . DIRECTORY_SEPARATOR . 'views'
		          . DIRECTORY_SEPARATOR . $viewName . '.php';

		$view = new View(array(
			'path'=>$viewPath,
			'values'=>$values,
		));

		return $view->render();
	}
}