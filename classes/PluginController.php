<?php

class PluginController extends Controller
{
	public function render($viewName, array $values=array())
	{
		// $className = get_class($this);
		// $controllerName = lcfirst(str_replace('Controller', '', $className));

		// $viewPath = VIEWS_PATH . DIRECTORY_SEPARATOR . $controllerName . DIRECTORY_SEPARATOR . $viewName . '.php';
		// $layoutPath = LAYOUTS_PATH . DIRECTORY_SEPARATOR . $this->layoutName . '.php';

		// $view = new View(array(
		// 	'path'=>$viewPath,
		// 	'values'=>$values,
		// ));

		// $layout = new View(array(
		// 	'path'=>$layoutPath,
		// 	'values'=>array(
		// 		'content'=>$view->render(),
		// 	),
		// ));

		// return $layout->render();
	}
}