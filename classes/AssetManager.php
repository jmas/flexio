<?php

class AssetManager
{
	/**
	 *
	 */
	const TYPE_CSS=1;
	const TYPE_JS=2;

	/**
	 *
	 */
	const POS_HEAD=1;
	const POS_BODY_TOP=2;
	const POS_BODY_BOTTOM=3;

	/**
	 *
	 */
	protected $itemTemplates = array(
		self::TYPE_CSS => '<link href="{URL}" rel="stylesheet" />',
		self::TYPE_JS => '<script src="{URL}"></script>',
	);

	/**
	 *
	 */
	protected $assets = array();

	/**
	 *
	 */
	public function add($url, $type=self::TYPE_CSS, $pos=self::POS_HEAD)
	{
		if (! isset($this->assets[$type])) {
			$this->assets[$type] = array();
		}

		if (! isset($this->assets[$type][$pos])) {
			$this->assets[$type][$pos] = array();
		}

		$this->assets[$type][$pos][] = $url;
	}

	/**
	 *
	 */
	public function render($type=self::TYPE_CSS, $pos=self::POS_HEAD)
	{
		$result = array();

		if (isset($this->assets[$type]) && isset($this->assets[$type][$pos])) {
			foreach ($this->assets[$type][$pos] as $url) {
				$result[] = str_replace('{URL}',  $url, $this->itemTemplates[$type]);
			}
		}
		
		return implode('', $result);
	}
}