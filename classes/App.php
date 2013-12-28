<?php

defined('APP_FOLDER_NAME') OR define('APP_FOLDER_NAME', 'app');
defined('LAYOUTS_FOLDER_NAME') OR define('LAYOUTS_FOLDER_NAME', 'layouts');
defined('ASSETS_FOLDER_NAME') OR define('ASSETS_FOLDER_NAME', 'assets');

defined('ROOT_PATH') OR define('ROOT_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
defined('APP_PATH') OR define('APP_PATH', realpath(ROOT_PATH . DIRECTORY_SEPARATOR . APP_FOLDER_NAME));
defined('CLASSES_PATH') OR define('CLASSES_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'classes');
defined('ASSETS_PATH') OR define('ASSETS_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . ASSETS_FOLDER_NAME);
defined('HELPERS_PATH') OR define('HELPERS_PATH', CLASSES_PATH . DIRECTORY_SEPARATOR . 'helpers');
defined('CONTROLLERS_PATH') OR define('CONTROLLERS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'controllers');
defined('MODELS_PATH') OR define('MODELS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'models');
defined('VIEWS_PATH') OR define('VIEWS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'views');
defined('PLUGINS_PATH') OR define('PLUGINS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'plugins');
defined('LAYOUTS_PATH') OR define('LAYOUTS_PATH', VIEWS_PATH . DIRECTORY_SEPARATOR . LAYOUTS_FOLDER_NAME);
defined('THEMES_PATH') OR define('THEMES_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'themes');

defined('CONFIG_FILE_NAME') OR define('CONFIG_FILE_NAME', 'config.php');
defined('PLUGINS_CONFIG_FILE_NAME') OR define('PLUGINS_CONFIG_FILE_NAME', 'plugins.php');

/**
 * @class App
 */
class App
{
	const STATUS_DEV = 'development';
	const STATUS_PROD = 'production';

	/**
	 *
	 */
	static protected $instance;

	/**
	 *
	 */
	protected $config = array(
		'theme'=>null,
		'status'=>self::STATUS_PROD,
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
			'class'=>'ModelManager',
			'dbConnectionName'=>'db',
		),
		'plugins'=>array(
			'class'=>'PluginManager',
		),
	);

	/**
	 *
	 */
	protected $params=array();

	/**
	 *
	 */
	protected $controller;

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
	public function getParams()
	{
		return $this->params;
	}

	/**
	 *
	 */
	public function getParam($key)
	{
		if (isset($this->params[$key])) {
			return $this->params[$key];
		}

		return null;
	}

	/**
	 *
	 */
	public function getBaseUrl($absolute=false)
	{
		return rtrim(sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['HTTP_HOST'],
			parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
		), '/');
	}

	/**
	 *
	 */
	public function getAssetUrl($path)
	{
		return $this->getBaseUrl() . '/' . ASSETS_FOLDER_NAME . '/' . $path;
	}

	/**
	 *
	 */
	public function moveAssets()
	{
		$assetsPath = ASSETS_PATH;
		$outAssetsPath = ASSETS_PATH . DIRECTORY_SEPARATOR . APP_FOLDER_NAME;

		if (! is_dir($assetsPath)) {
			return false;
		}

		if (is_dir($outAssetsPath)) {
			if ($this->status === self::STATUS_PROD) {
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
	public function run()
	{
		$this->loader->register();
		$this->moveAssets();
		$this->plugins->registerInstalled();

		$this->observer->notify('appStart');

		$path = $this->request->getParam('path');
		$this->params = $this->router->route($path);

		$controllerName = preg_replace('/[^A-Za-z0-9_\-]/', '', $this->params['controller']);
		$actionName = preg_replace('/[^A-Za-z0-9_\-]/', '', $this->params['action']);

		$controllerClassName = ucfirst($controllerName) . 'Controller';

		if (! empty($this->params['plugin'])) {
			$pluginName = preg_replace('/[^A-Za-z0-9_\-]/', '', $this->params['plugin']);

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

		$this->controller = new $controllerClassName;
		$this->controller->exec($actionName, $this->params);

		$this->observer->notify('appEnd');
	}
}