<?php

class User extends Model
{
	public function getPermissions()
	{
		return explode(',', $this->permissions);
	}
}