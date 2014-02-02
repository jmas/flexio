<?php

class AssetManager
{
	/**
	 *
	 */
	const TYPE_CSS=1;
	const TYPE_JS=2;
	const TYPE_CSS_PLAIN=3;
	const TYPE_JS_PLAIN=4;

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
		self::TYPE_CSS => '<link href="{ITEM}" rel="stylesheet" />',
		self::TYPE_JS => '<script src="{ITEM}" type="text/javascript"></script>',
		self::TYPE_CSS_PLAIN => '<style type="text/css">{ITEM}</style>',
		self::TYPE_JS_PLAIN => '<script type="text/javascript">{ITEM}</script>',
	);

	/**
	 *
	 */
	protected $assets = array();

	/**
	 *
	 */
	public function add($item, $type=self::TYPE_CSS, $pos=self::POS_HEAD)
	{
		if (! isset($this->assets[$type])) {
			$this->assets[$type] = array();
		}

		if (! isset($this->assets[$type][$pos])) {
			$this->assets[$type][$pos] = array();
		}

		if (is_array($item)) {
			foreach ($item as $value) {
				$this->assets[$type][$pos][] = $value;
			}
		} else {
			$this->assets[$type][$pos][] = $item;
		}
	}

	/**
	 *
	 */
	public function addJs($url, $pos=self::POS_HEAD)
	{
		$this->add($url, self::TYPE_JS, $pos);
	}

	/**
	 *
	 */
	public function addCss($url, $pos=self::POS_HEAD)
	{
		$this->add($url, self::TYPE_CSS, $pos);
	}

	/**
	 *
	 */
	public function addPlainCss($content, $pos=self::POS_HEAD)
	{
		$this->add($content, self::TYPE_CSS_PLAIN, $pos);
	}

	/**
	 *
	 */
	public function addPlainJs($content, $pos=self::POS_HEAD)
	{
		$this->add($content, self::TYPE_JS_PLAIN, $pos);
	}

	/**
	 *
	 */
	public function render($type=self::TYPE_CSS, $pos=self::POS_HEAD)
	{
		$result = array();

		if (isset($this->assets[$type]) && isset($this->assets[$type][$pos])) {
			foreach ($this->assets[$type][$pos] as $item) {
				$result[] = str_replace('{ITEM}',  $item, $this->itemTemplates[$type]);
			}
		}

		return implode("\n", $result);
	}
}