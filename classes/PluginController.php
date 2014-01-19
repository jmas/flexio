<?php

/**
 * @class PluginController
 */
class PluginController extends Controller
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		parent::beforeExec($actionName, $params);

		if (! Flexio::app()->auth->isLoggedIn()) {
			Flexio::app()->redirect(array(
				'controller'=>'auth',
				'action'=>'index',
			));
		}

		$this->setLayoutValue('isNavEnabled', true);

		return true;
	}

	/**
	 *
	 */
	public function getPlugin()
	{
		$pluginName = Flexio::app()->getParam('plugin');
		return Flexio::app()->plugins->getPlugin($pluginName);
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

		$themeName = Flexio::app()->theme;

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