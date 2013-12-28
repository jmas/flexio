<?php

/**
 * @class Db
 */
class Db extends PDO
{
	/**
	 *
	 */
	public function __construct($config=array())
	{
		$this->dsn = empty($config['dsn']) ? null: $config['dsn'];
		$this->username = empty($config['username']) ? null: $config['username'];
		$this->password = empty($config['password']) ? null: $config['password'];
		$this->driverOptions = empty($config['driverOptions']) ? null: $config['driverOptions'];

		parent::__construct($this->dsn, $this->username, $this->password, $this->driverOptions);

		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}