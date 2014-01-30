<?php

/**
 * @class User
 */
class User extends Model
{
	/**
	 *
	 */
	public static function fields()
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
			'username'=>function($str) {
				if (empty($str)) {
					return false;
				}

				if ($this->isNew()) {
					$model = Flexio::app()->models->findByAttrs('User', array(
						'username'=>$this->username,
					));

					if ($model !== null) {
						return false;
					}
				}

				return true;
			},
			'password'=>function($str) {
				if ($this->isNew()) {
					return ! empty($str);
				} else if (! empty($str)) {
					return strlen($str) > 3;
				}

				return true;
			},
			'passwordRetype'=>function($str) {
				if ($this->isNew() || ! empty($this->password)) {
					return strlen($str) > 3 && $this->password === $str;
				}

				return true;
			},
			'email'=>function($str) {
				if (! filter_var($str, FILTER_VALIDATE_EMAIL)) {
					return false;
				}

				if ($this->isNew()) {
					$model = Flexio::app()->models->findByAttrs('User', array(
						'email'=>$this->email,
					));

					if ($model !== null) {
						return false;
					}
				}

				return true;
			}
		);
	}

	/**
	 *
	 */
	public function getPermissions()
	{
		if (is_array($this->permissions)) {
			return $this->permissions;
		}

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

		if (! empty($this->passwordRetype)) { // password is modified
			$this->hashPassword();
		} else { // password not modified. Make it null for skip saving to DB
			$this->password = null;
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