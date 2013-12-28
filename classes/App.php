<?php

defined('ROOT_PATH') OR define('ROOT_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
defined('APP_PATH') OR define('APP_PATH', realpath(ROOT_PATH . DIRECTORY_SEPARATOR . 'app'));
defined('CLASSES_PATH') OR define('CLASSES_PATH', dirname(__FILE__));
defined('HELPERS_PATH') OR define('HELPERS_PATH', CLASSES_PATH . DIRECTORY_SEPARATOR . 'helpers');
defined('CONTROLLERS_PATH') OR define('CONTROLLERS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'controllers');
defined('MODELS_PATH') OR define('MODELS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'models');
defined('VIEWS_PATH') OR define('VIEWS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'views');
defined('PLUGINS_PATH') OR define('PLUGINS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'plugins');
defined('LAYOUTS_PATH') OR define('LAYOUTS_PATH', VIEWS_PATH . DIRECTORY_SEPARATOR . 'layouts');

defined('CONFIG_FILE_NAME') OR define('CONFIG_FILE_NAME', 'config.php');
defined('PLUGINS_CONFIG_FILE_NAME') OR define('PLUGINS_CONFIG_FILE_NAME', 'plugins.php');

class App
{
	/**
	 *
	 */
	static protected $instance;

	/**
	 *
	 */
	protected $config = array(
		'request'=>array(
			'class'=>'Request',
		),
		'observer'=>array(
			'class'=>'Observer',
		),
		'loader'=>array(
			'class'=>'Loader',
			'paths'=>array(
				CLASSES_PATH,
				HELPERS_PATH,
				MODELS_PATH,
			),
		),
		'router'=>array(
			'class'=>'Router',
			'defaultController'=>'page',
			'defaultAction'=>'index',
			'routes'=>array(
				'plugin/<plugin:\w+>/<controller:\w+>',
				'plugin/<plugin:\w+>/<controller:\w+>/<action:\w+>',
				'<controller:\w+>/<action:\w+>/<id:\d+>',
				'<controller:\w+>/<action:\w+>',
			),
		),
		'db'=>array(
			'class'=>'Db',
			'dsn'=>'mysql:dbname=app;host=127.0.0.1',
			'username'=>'root',
			'password'=>'root',
		),
		'models'=>array(
			'class'=>'ModelFinder',
			'dbConnectionName'=>'db',
		),
		'plugins'=>array(
			'class'=>'PluginManager',
		),
	);

	/**
	 *
	 */
	static public function instance()
	{
		if (! self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct($config=array())
	{
		if (! class_exists('Arr')) {
			require_once(HELPERS_PATH . DIRECTORY_SEPARATOR . 'Arr.php');
		}

		if (! class_exists('Loader')) {
			require_once(CLASSES_PATH . DIRECTORY_SEPARATOR . 'Loader.php');
		}

		$configPath = APP_PATH . DIRECTORY_SEPARATOR . CONFIG_FILE_NAME;

		if (file_exists($configPath)) {
			$config = Arr::merge(require_once($configPath), $config);
		}

		$this->config = Arr::merge(
			$this->config,
			$config
		);
	}

	/**
	 *
	 */
	public function __get($key)
	{
		return $this->getConfig($key);
	}

	/**
	 *
	 */
	public function getConfig($key, $defaultValue=null)
	{
		if (isset($this->config[$key])) {
			if (gettype($this->config[$key])==='array' && ! empty($this->config[$key]['class'])) {
				$className = $this->config[$key]['class'];
				unset($this->config[$key]['class']);
				$instance = new $className($this->config[$key]);
				$this->config[$key] = $instance;
			}

			return $this->config[$key];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function run()
	{
		$this->loader->register();
		$this->plugins->registerInstalled();

		$this->observer->notify('appStart');

		$path = $this->request->getParam('path');
		$params = $this->router->route($path);

		$controllerName = preg_replace('/[^A-Za-z0-9_\-]/', '', $params['controller']);
		$actionName = preg_replace('/[^A-Za-z0-9_\-]/', '', $params['action']);

		$controllerClassName = ucfirst($controllerName) . 'Controller';

		if (! empty($params['plugin'])) {
			$pluginName = preg_replace('/[^A-Za-z0-9_\-]/', '', $params['plugin']);

			if (! $this->plugins->isInstalled($pluginName)) {
				throw new Exception("Plugin '{$pluginName}' not installed.");
			}

			$controllerPath = PLUGINS_PATH . DIRECTORY_SEPARATOR
							. $pluginName . DIRECTORY_SEPARATOR
							. 'controllers' . DIRECTORY_SEPARATOR
							. $controllerClassName . '.php';
		} else {
			$controllerPath = CONTROLLERS_PATH . DIRECTORY_SEPARATOR
							. $controllerClassName . '.php';
		}

		if (! file_exists($controllerPath)) {
			throw new Exception("File for controller '{$controllerName}' not found.");
		}

		require_once($controllerPath);

		if (! class_exists($controllerClassName)) {
			throw new Exception("Controller class '{$controllerClassName}' not found.");
		}

		$controller = new $controllerClassName;
		$controller->exec($actionName, $params);

		$this->observer->notify('appEnd');
	}
}