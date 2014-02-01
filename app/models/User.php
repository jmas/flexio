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
			'username'=>function($key, $model) {
				$value = $model->getAttr($key);

				if (empty($value)) {
					$model->addError($key, 'Field is required.');
				}

				if ($model->isNew()) {
					$userModel = $model->manager->findByAttrs('User', array(
						'username'=>$model->username,
					));

					if ($userModel !== null) {
						$model->addError($key, 'This username already taked.');
					}
				}
			},
			'password'=>function($key, $model) {
				$value = $model->getAttr($key);

				if ($model->isNew() && empty($value)) {
					$model->addError($key, 'Field is required.');
				}

				if (! empty($value) && strlen($value) < 3) {
					$model->addError($key, 'Password should contain more than 3 chars.');
				}
			},
			'passwordRetype'=>function($key, $model) {
				$value = $model->getAttr($key);

				if (! empty($model->password) && $model->password !== $value) {
					$model->addError($key, 'Password retyped not correctly.');
				}
			},
			'email'=>function($key, $model) {
				$value = $model->getAttr($key);

				if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$model->addError($key, 'Field contain not correctly e-mail address.');
				}

				if ($model->isNew()) {
					$userModel = $model->manager->findByAttrs('User', array(
						'email'=>$model->email,
					));

					if ($userModel !== null) {
						$model->addError($key, 'This e-mail already taked.');
					}
				}
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
	public function beforeDelete()
	{
		if ($this->username === 'admin') {
			return false;
		}

		return true;
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
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=22&d=mm&r=g';
	}
}