<?php

/**
 * @class User
 */
class User extends Model
{
	/**
	 *
	 */
	public function fields()
	{
		return array(
			'id',
			'name',
			'username',
			'password',
			'permissions',
			'create_date',
			'update_date',
			'create_user_id',
			'email',
		);
	}

	/**
	 *
	 */
	public function validators()
	{
		return array(
			'username'=>function($str) { return !empty($str); },
			'password'=>function($str) { return !empty($str); },
			'myPassword'=>function($str) {
				if (! empty($str)) {
					return strstr($str) > 3;
				}

				return true;
			},
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

	/**
	 *
	 */
	public function hasPermission($name)
	{
		return in_array($name, $this->getPermissions());
	}

	/**
	 *
	 */
	public function beforeSave()
	{
		if (is_array($this->permissions)) {
			$this->permissions = implode(',', $this->permissions);
		}

		if (isset($this->myPassword)) {
			$this->password = $this->myPassword;
			$this->hashPassword();
		}

		return parent::beforeSave();
	}

	/**
	 *
	 */
	public function hashPassword()
	{
		$this->password = sha1($this->password);
	}

	/**
	 *
	 */
	public function getGravatarUrl()
	{
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=40&d=mm&r=g';
	}
}