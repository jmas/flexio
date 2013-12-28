<?php

/**
 * @class Controller
 */
class Controller
{
	/**
	 *
	 */
	protected $layoutName='default';

	/**
	 *
	 */
	public function exec($actionName, array $params=array())
	{
		if (! $this->beforeExec($actionName, $params)) {
			throw new Exception("Before exec is not valid.");
		}

		$methodName = $actionName . 'Action';

		if (! method_exists($this, $methodName)) {
			throw new Exception("Action '{$actionName}' is not exists.");
		}

		$result = Fn::callNamed($this, $methodName, $params);

		if (! $this->afterExec($actionName, $params)) {
			throw new Exception("After exec is not valid.");
		}

		return $result;
	}

	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		App::instance()->observer->notify('controllerBeforeExec', $this, $actionName, $params);
		return true;
	}

	/**
	 *
	 */
	public function afterExec($actionName, array $params=array())
	{
		App::instance()->observer->notify('controllerAfterExec', $this, $actionName, $params);
		return true;
	}

	/**
	 *
	 */
	public function render($viewName, array $values=array())
	{
		$viewPath = $this->getViewPath($viewName);
		$layoutPath = $this->getLayoutPath();

		$view = new View(array(
			'path'=>$viewPath,
			'values'=>$values,
		));

		$layout = new View(array(
			'path'=>$layoutPath,
			'values'=>array(
				'content'=>$view->render(),
			),
		));

		return $layout->render();
	}

	/**
	 *
	 */
	public function getViewPath($viewName)
	{
		$viewPath = VIEWS_PATH . DIRECTORY_SEPARATOR . $this->getId() . DIRECTORY_SEPARATOR . $viewName . '.php';

		$themeName = App::instance()->theme;

		if ($themeName!==null) {
			$themeViewPath = THEMES_PATH . DIRECTORY_SEPARATOR
			      . $themeName . DIRECTORY_SEPARATOR
			      . APP_FOLDER_NAME . DIRECTORY_SEPARATOR
			      . $this->getId() . DIRECTORY_SEPARATOR
			      . $viewName . '.php';

			if (is_file($themeViewPath)) {
				$viewPath = $themeViewPath;
			}
		}

		return $viewPath;
	}

	/**
	 *
	 */
	public function getLayoutPath()
	{
		$layoutPath = LAYOUTS_PATH . DIRECTORY_SEPARATOR . $this->layoutName . '.php';

		$themeName = App::instance()->theme;

		if ($themeName!==null) {
			$themeLayoutPath = THEMES_PATH . DIRECTORY_SEPARATOR
			      . $themeName . DIRECTORY_SEPARATOR
			      . APP_FOLDER_NAME . DIRECTORY_SEPARATOR
			      . LAYOUTS_FOLDER_NAME . DIRECTORY_SEPARATOR
			      . $this->layoutName . '.php';

			if (is_file($themeLayoutPath)) {
				$layoutPath = $themeLayoutPath;
			}
		}

		return $layoutPath;
	}

	/**
	 *
	 */
	public function getId()
	{
		return lcfirst(basename(get_class($this), 'Controller'));
	}
}