<?php

/**
 * @class Router
 */
class Router
{
	/**
	 *
	 */
	protected $routes = array();

	/**
	 *
	 */
	protected $defaultParams=array(
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
		$defaultParams = $this->defaultParams;

		foreach ($this->routes as $key=>$pattern) {
			if (gettype($pattern) === 'array') {
				$defaultParams = array_merge($defaultParams, $pattern);
				$pattern = $key;
			}

			preg_match_all('/<(\w+):(.*?)>/', $pattern, $patternSegments, PREG_SET_ORDER);

			$realPattern = $pattern;

			foreach ($patternSegments as $segment) {
				$realPattern = str_replace($segment[0], '(' . $segment[2] . ')', $realPattern);
			}

			$realPattern = '/' . addcslashes($realPattern, '/') . '/';

			if (preg_match($realPattern, $path, $matches)) {
				foreach ($matches as $i=>$match) {
					if ($i===0 || empty($patternSegments[$i-1])) { continue; }
					
					$params[ $patternSegments[$i-1][1] ] = $match;
				}
				
				break;
			}
		}

		foreach ($defaultParams as $key=>$value) {
			if (! isset($params[$key])) {
				$params[$key]=$value;
			}
		}

		$this->params = $params;

		return $this->params;
	}

	/**
	 * Create path by route.
	 * @param $perms array Route properties array
	 * @return string Created path
	 */
	public function createPath(array $params=array(), $isQuery=false)
	{
		$realPath = null;
		$bestPattern = null;
		$bestPatternSegments=array();
		$bestCount = 0;
		$paramsKeys = array_keys($params);

		$params = Arr::merge($this->defaultParams, $params);

		foreach ($this->routes as $pattern) {
			// $accepted = true;

			preg_match_all('/<(\w+):(.*?)>/', $pattern, $patternSegments, PREG_SET_ORDER);
			
			$count=0;

			foreach ($patternSegments as $segment) {
				if (in_array($segment[1], $paramsKeys)) {
					$count++;
				} else {
					$count--;
				}
			}

			if ($count > $bestCount) {
				$bestPattern = $pattern;
				$bestCount = $count;
				$bestPatternSegments = $patternSegments;
			}

			// if ($accepted === true) { break; }
		}

		$realPath = $bestPattern;

		foreach ($bestPatternSegments as $segment) {
			if (isset($params[ $segment[1] ]) === true
				&& preg_match('/(' . $segment[2] . ')/', $params[ $segment[1] ]))
			{
				$realPath = str_replace($segment[0], $params[ $segment[1] ], $realPath);
				unset($params[ $segment[1] ]);
			}
		}

		// var_dump($params, $bestPattern);

		if ($realPath === null) { return null; }

		if (empty($params) === false) {
			$realPath .= ($isQuery ? '&': '?') . http_build_query($params);
		}

		return $realPath;
	}
}