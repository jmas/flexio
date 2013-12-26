<?php

/**
 * @class Router
 */
class Router
{
	/**
	 *
	 */
	public $routes = array();

	public $defaultParams=array(
		'controller'=>'default',
		'action'=>'default',
	);

	/**
	 *
	 */
	public function __construct($config=array())
	{
		foreach ($config as $key=>$value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 * Get route properties.
	 * @param $path Path
	 * @return array Route properties array
	 */
	public function route($path)
	{
		$params = array();

		foreach ($this->routes as $pattern) {
			preg_match_all('/<(\w+):(.*?)>/', $pattern, $patternSegments, PREG_SET_ORDER);

			$realPattern = $pattern;

			foreach ($patternSegments as $segment) {
				$realPattern = str_replace($segment[0], '(' . $segment[2] . ')', $realPattern);
			}

			$realPattern = '/' . addcslashes($realPattern, '/') . '/';

			if (preg_match($realPattern, $path, $matches)) {
				foreach ($matches as $i=>$match) {
					if ($i===0) { continue; }

					$params[ $patternSegments[$i-1][1] ] = $match;
				}
				
				break;
			}
		}

		foreach ($this->defaultParams as $key=>$value) {
			if (! isset($params[$key])) {
				$params[$key]=$value;
			}
		}

		return $params;
	}

	/**
	 * Create path by route.
	 * @param $perms array Route properties array
	 * @return string Created path
	 */
	public function createPath(array $params=array())
	{
		$realPath = null;

		foreach ($this->routes as $pattern) {
			$realPath = $pattern;
			$accepted = true;

			preg_match_all('/<(\w+):(.*?)>/', $realPath, $patternSegments, PREG_SET_ORDER);

			foreach ($patternSegments as $segment) {
				if (isset($params[ $segment[1] ]) === true
					&& preg_match('/' . $segment[2] . '/', $params[ $segment[1] ]))
				{
					$realPath = str_replace($segment[0], $params[ $segment[1] ], $realPath);
					unset($params[ $segment[1] ]);
				} else {
					$accepted = false;
					break;
				}
			}

			if ($accepted === true) { break; }
		}

		if ($realPath === null) { return null; }

		if (empty($params) === false) {
			$realPath .= '?' . http_build_query($params);
		}

		return $realPath;
	}
}