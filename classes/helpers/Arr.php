<?php

class Arr
{
	/**
	 *
	 */
	static public function merge()
	{
		$arrays = func_get_args();
		$result = array();

		for ($i=0, $len=count($arrays); $i<$len-1; $i++) {
			if (empty($result)) {
				$result = $arrays[$i];
			}

			foreach ($arrays[$i+1] as $key=>$value) {
				if (isset($arrays[$i][$key]) && gettype($arrays[$i][$key])==='array' && gettype($value)==='array') {
					$result[$key] = self::merge($arrays[$i][$key], $value);
				} else {
					$result[$key] = $value;
				}
			}
		}

		return $result;
	}
}