<?php

return array(
	'defaultController'=>'page',
	'defaultAction'=>'index',
	'db'=>array(
		'dsn'=>'mysql:dbname=flexio;host=127.0.0.1',
	),
	'plugins'=>require_once('plugins.php'),
	'router'=>array(
		'defaultParams'=>array(
			'controller'=>'default',
			'action'=>'index',
		),
	),
);