<?php

class PluginController extends Controller
{
	public function render($viewName, array $values=array())
	{
		$className = get_class($this);
		$controllerName = lcfirst(str_replace('Controller', '', $className));

		$pluginName = App::instance()->getParam('plugin');
		$plugin = App::instance()->plugins->getPlugin($pluginName);

		$viewPath = $plugin->getPath() . DIRECTORY_SEPARATOR
				. 'views' . DIRECTORY_SEPARATOR
				. $this->getId() . DIRECTORY_SEPARATOR
				. $viewName . '.php';
		
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