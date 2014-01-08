<?php

/**
 * @class User
 */
class User extends Model
{
	/**
	 *
	 */
	public function validators()
	{
		return array(
			'username'=>function($str) { return !empty($str); },
			'password'=>function($str) { return !empty($str); },
			'email'=>function($str) { return filter_var($str, FILTER_VALIDATE_EMAIL); }
		);
	}

	/**
	 *
	 */
	public function getPermissions()
	{
		return explode(',', $this->permissions);
	}
}