<?php

defined('APP_FOLDER_NAME') OR define('APP_FOLDER_NAME', 'app');
defined('LAYOUTS_FOLDER_NAME') OR define('LAYOUTS_FOLDER_NAME', 'layouts');
defined('ASSETS_FOLDER_NAME') OR define('ASSETS_FOLDER_NAME', 'assets');
defined('CONTROLLERS_FOLDER_NAME') OR define('CONTROLLERS_FOLDER_NAME', 'controllers');
defined('VIEWS_FOLDER_NAME') OR define('VIEWS_FOLDER_NAME', 'views');
defined('MODELS_FOLDER_NAME') OR define('MODELS_FOLDER_NAME', 'models');

defined('CONFIG_FILE_NAME') OR define('CONFIG_FILE_NAME', 'config.php');
defined('PLUGINS_CONFIG_FILE_NAME') OR define('PLUGINS_CONFIG_FILE_NAME', 'plugins.php');
defined('LOADER_FILE_NAME') OR define('LOADER_FILE_NAME', 'Loader.php');

defined('ROOT_PATH') OR define('ROOT_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
defined('APP_PATH') OR define('APP_PATH', realpath(ROOT_PATH . DIRECTORY_SEPARATOR . APP_FOLDER_NAME));
defined('CLASSES_PATH') OR define('CLASSES_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'classes');
defined('ASSETS_PATH') OR define('ASSETS_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . ASSETS_FOLDER_NAME);
defined('HELPERS_PATH') OR define('HELPERS_PATH', CLASSES_PATH . DIRECTORY_SEPARATOR . 'helpers');
defined('CONTROLLERS_PATH') OR define('CONTROLLERS_PATH', APP_PATH . DIRECTORY_SEPARATOR . CONTROLLERS_FOLDER_NAME);
defined('MODELS_PATH') OR define('MODELS_PATH', APP_PATH . DIRECTORY_SEPARATOR . MODELS_FOLDER_NAME);
defined('VIEWS_PATH') OR define('VIEWS_PATH', APP_PATH . DIRECTORY_SEPARATOR . VIEWS_FOLDER_NAME);
defined('PLUGINS_PATH') OR define('PLUGINS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'plugins');
defined('LAYOUTS_PATH') OR define('LAYOUTS_PATH', VIEWS_PATH . DIRECTORY_SEPARATOR . LAYOUTS_FOLDER_NAME);
defined('THEMES_PATH') OR define('THEMES_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'themes');
defined('VENDORS_PATH') OR define('VENDORS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'vendors');

defined('PLUGINS_CONFIG_FILE_PATH') OR define('PLUGINS_CONFIG_FILE_PATH', APP_PATH . DIRECTORY_SEPARATOR . PLUGINS_CONFIG_FILE_NAME);

/**
 * @class App
 */
class Flexio
{
	const STATUS_DEV = 'development';
	const STATUS_PROD = 'production';
	const URL_MODE_PATH = 'path';
	const URL_MODE_QUERY = 'query';

	/**
	 *
	 */
	static protected $instance;

	/**
	 *
	 */
	protected $config = array(
		'name'=>'App',
		'theme'=>null,
		'status'=>self::STATUS_PROD,
		'urlPathName'=>'path',
		'urlMode'=>self::URL_MODE_QUERY,
		'defaultRoute'=>array(
			'controller'=>'page',
			'action'=>'index',
		),
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
			'defaultParams'=>array(
				'controller'=>'page',
				'action'=>'index',
			),
			'routes'=>array(
				// '<controller:(page|user|layout|snippet)>/<action:\w+>',
				// 'plugin/<plugin:\w+>/<controller:\w+>',
				// 'plugin/<plugin:\w+>/<controller:\w+>/<action:\w+>',
				// '<path:.+>',
				// '<controller:\w+>/<action:\w+>/<id:\d+>',
				// '<controller:\w+>/<action:\w+>',
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
		'pages'=>array(
			'class'=>'PageManager',
			'dbConnectionName'=>'db',
		),
		'plugins'=>array(
			'class'=>'PluginManager',
		),
		'auth'=>array(
			'class'=>'Auth',
		),
		'flash'=>array(
			'class'=>'Flash',
		),
		'assets'=>array(
			'class'=>'AssetManager',
		),
		'nav'=>array(
			'class'=>'Nav',
			'items'=>array(
				array(
					'name'=>'Content',
					'items'=>array(
						array(
							'name'=>'Pages',
							'url'=>array(
								'controller'=>'page',
								'action'=>'index',
							),
						),
						array(
							'name'=>'Assets',
							'url'=>array(
								'controller'=>'asset',
								'action'=>'index',
							),
						),
					),
				),
				array(
					'name'=>'Design',
					'items'=>array(
						array(
							'name'=>'Layouts',
							'url'=>array(
								'controller'=>'layout',
								'action'=>'index',
							),
						),
						array(
							'name'=>'Snippets',
							'url'=>array(
								'controller'=>'snippet',
								'action'=>'index',
							),
						),
					),
				),
				array(
					'name'=>'System',
					'items'=>array(
						array(
							'name'=>'Users',
							'url'=>array(
								'controller'=>'user',
								'action'=>'index',
							),
						),
						array(
							'name'=>'Settings',
							'url'=>array(
								'controller'=>'setting',
								'action'=>'index',
							),
						),
						array(
							'name'=>'Plugins',
							'url'=>array(
								'controller'=>'plugins',
								'action'=>'index',
							),
						),
						array(
							'name'=>'Update',
							'url'=>array(
								'controller'=>'setting',
								'action'=>'update',
							),
						),
					),
				),
			),
		),
	);

	/**
	 *
	 */
	protected $params=array();

	/**
	 *
	 */
	protected $permissions=array();

	/**
	 *
	 */
	protected $controller;

	/**
	 *
	 */
	static public function app()
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
			require_once(CLASSES_PATH . DIRECTORY_SEPARATOR . LOADER_FILE_NAME);
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
				$this->config[$key]['app'] = $this;
				
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
		return $this->getBaseUrl() . '/' . ASSETS_FOLDER_NAME . '/' . APP_FOLDER_NAME . '/' . $path;
	}

	/**
	 *
	 */
	public function createUrl($params)
	{
		if (! empty($params[0])) {
			$params['controller'] = $params[0];
			unset($params[0]);
		}

		if (! empty($params[1])) {
			$params['action'] = $params[1];
			unset($params[1]);
		}

		return $this->getBaseUrl() . ($this->urlMode === self::URL_MODE_QUERY ? '?' . $this->urlPathName . '=': '/') . $this->router->createPath($params, $this->urlMode === self::URL_MODE_QUERY);
	}

	/**
	 *
	 */
	public function redirect(array $params=array())
	{
		$url =$this->createUrl($params);

		header('Location: ' . $url);

		$this->end();
	}

	/**
	 *
	 */
	public function getAllPermissions()
	{
		if (empty($this->permissions)) {
			$permissions=array('editor','developer','administrator');

			$this->permissions=array_merge($permissions, $this->plugins->getAllPermissions());
		}
		
		return $this->permissions;
	}

	/**
	 *
	 */
	public function moveAssets()
	{
		$assetsPath = APP_PATH . DIRECTORY_SEPARATOR . ASSETS_FOLDER_NAME;
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
		session_start();

		$this->loader->register();
		$this->moveAssets();
		$this->auth->load();
		$this->plugins->registerInstalled(array(
			'app'=>$this,
		));

		$this->observer->notify('appStart');

		$path = $this->request->getParam($this->urlPathName);
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
							. CONTROLLERS_FOLDER_NAME . DIRECTORY_SEPARATOR
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

		$this->controller = new $controllerClassName(array(
			'app'=>$this,
		));
		$this->controller->exec($actionName, Arr::merge($_GET, $this->params));

		$this->observer->notify('appEnd');
	}
}