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

		if (! $this->app->auth->isLoggedIn()) {
			$this->app->redirect(array(
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
		$pluginName = $this->app->getParam('plugin');
		return $this->app->plugins->get($pluginName);
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

		$themeName = $this->app->theme;

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