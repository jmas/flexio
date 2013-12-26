<?php

class Controller
{
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
		App::instance()->observer->notify('controllerBeforeExec', $actionName, $params);
		return true;
	}

	/**
	 *
	 */
	public function afterExec($actionName, array $params=array())
	{
		App::instance()->observer->notify('controllerAfterExec', $actionName, $params);
		return true;
	}

	public function render($viewName, array $values=array())
	{
		$className = get_class($this);
		$controllerName = lcfirst(str_replace('Controller', '', $className));

		$viewPath = VIEWS_PATH . DIRECTORY_SEPARATOR . $controllerName . DIRECTORY_SEPARATOR . $viewName . '.php';
		$layoutPath = LAYOUTS_PATH . DIRECTORY_SEPARATOR . $this->layoutName . '.php';

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
}