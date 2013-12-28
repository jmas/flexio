<?php

/**
 * @class PluginController
 */
class PluginController extends Controller
{
	/**
	 *
	 */
	public function getPlugin()
	{
		$pluginName = App::instance()->getParam('plugin');
		return App::instance()->plugins->getPlugin($pluginName);
	}

	/**
	 *
	 */
	public function render($viewName, array $values=array())
	{
		return parent::render($viewName, array(
			'plugin'=>$this->getPlugin(),
		));
	}

	/**
	 *
	 */
	public function getViewPath($viewName)
	{
		$viewPath = $this->getPlugin()->getPath() . DIRECTORY_SEPARATOR
				. VIEWS_FOLDER_NAME . DIRECTORY_SEPARATOR
				. $this->getId() . DIRECTORY_SEPARATOR
				. $viewName . '.php';

		$themeName = App::instance()->theme;

		if ($themeName!==null) {
			$themeViewPath = THEMES_PATH . DIRECTORY_SEPARATOR
			      . $themeName . DIRECTORY_SEPARATOR
			      . $this->getPlugin()->getId() . DIRECTORY_SEPARATOR
			      . $this->getId() . DIRECTORY_SEPARATOR
			      . $viewName . '.php';
			
			if (is_file($themeViewPath)) {
				$viewPath = $themeViewPath;
			}
		}

		return $viewPath;
	}
}