<?php

class Nav
{
	/**
	 *
	 */
	protected $items=array();

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
	 *
	 */
	public function render()
	{
		$result = '<ul class="nav navbar-nav">';

		foreach ($this->items as $item) {
			if (! empty($item['items'])) {
				$result .= '<li class="dropdown">';
				$result .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$item['name'].' <b class="caret"></b></a>';
				$result .= '<ul class="dropdown-menu">';

				foreach ($item['items'] as $subItem) {
					$result .= '<li><a href="' . App::instance()->createUrl($subItem['url']) . '">'.$subItem['name'].'</a></li>';
				}

				$result .= '</ul></li>';
			} else {
				$result .= '<li><a href="' . App::instance()->createUrl($item['url']) . '">'.$item['name'].'</a></li>';
			}
			
		}

		$result .= '</ul>';

		return $result;
	}

	/**
	 *
	 */
	public function append($items)
	{
		$this->items = $this->mergeItems($this->items, $items);
	}

	/**
	 *
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 *
	 */
	protected function mergeItems($items1, $items2)
	{
		$found = false;

		foreach ($items1 as $k1=>$item1) {
			foreach ($items2 as $k2=>$item2) {
				if ($item1['name'] === $item2['name'] && ! empty($item1['items']) && ! empty($item2['items'])) {
					$items1[$k1]['items'] = $this->mergeItems($item1['items'], $item2['items']);
					$found = true;
				}
			}
		}

		if (! $found) {
			$items1 = array_merge($items1, $items2);
		}

		return $items1;
	}
}