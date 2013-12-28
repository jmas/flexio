<?php

return array(
	'theme'=>'default',
	'db'=>array(
		'dsn'=>'mysql:dbname=flexio;host=127.0.0.1',
	),
	'plugins'=>require_once(APP_PATH . DIRECTORY_SEPARATOR . PLUGINS_CONFIG_FILE_NAME),
	'router'=>array(
		'defaultParams'=>array(
			'controller'=>'default',
			'action'=>'index',
		),
	),
);