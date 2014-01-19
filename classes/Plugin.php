<?php

/**
 * @class Plugin
 */
class Plugin
{
	/**
	 *
	 */
	protected $name;

	/**
	 *
	 */
	protected $version;

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
	public function permissions()
	{
		return array();
	}

	/**
	 *
	 */
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

		$modelsPath = $this->getPath() . DIRECTORY_SEPARATOR . MODELS_FOLDER_NAME;

		if (is_dir($modelsPath)) {
			App::instance()->loader->addPath($modelsPath);
		}

		$this->moveAssets();

		$navItems = $this->navItems();

		if ($navItems !== null) {
			App::instance()->nav->append($navItems);
		}
	}

	/**
	 *
	 */
	public function moveAssets()
	{
		$assetsPath = $this->getPath() . DIRECTORY_SEPARATOR . ASSETS_FOLDER_NAME;
		$outAssetsPath = ASSETS_PATH . DIRECTORY_SEPARATOR . $this->getId();

		if (! is_dir($assetsPath)) {
			return false;
		}
		
		if (is_dir($outAssetsPath)) {
			if (App::instance()->status === App::STATUS_PROD) {
				return false;
			} else {
				Fs::remove($outAssetsPath);
			}
		}

		//Fs::mkdir($outAssetsPath);
		Fs::copy($assetsPath, $outAssetsPath);

		return true;
	}

	/**
	 *
	 */
	public function getAssetUrl($path)
	{
		return App::instance()->getBaseUrl() . '/' . ASSETS_FOLDER_NAME . '/' . $this->getId() . '/' . $path;
	}

	/**
	 *
	 */
	public function beforeInstall() { return true; }

	/**
	 *
	 */
	public function beforeUninstall() { return true; }

	/**
	 *
	 */
	public function navItems() { return null; }

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
		$viewPath = $this->getPath() . DIRECTORY_SEPARATOR . VIEWS_FOLDER_NAME
		          . DIRECTORY_SEPARATOR . $viewName . '.php';

        $themeName = App::instance()->theme;

		if ($themeName!==null) {
			$themeViewPath = THEMES_PATH . DIRECTORY_SEPARATOR
			      . $themeName . DIRECTORY_SEPARATOR
			      . $this->getId() . DIRECTORY_SEPARATOR
			      . $viewName . '.php';
			
			if (is_file($themeViewPath)) {
				$viewPath = $themeViewPath;
			}
		}

		$view = new View(array(
			'path'=>$viewPath,
			'values'=>$values,
		));

		$view->setValue('plugin', $this);

		return $view->render();
	}
}