<?php

return array(
	'name'=>'Flexio',
	'theme'=>'null',
	'db'=>array(
		'dsn'=>'mysql:dbname=flexio;host=127.0.0.1',
	),
	'router'=>array(
		'routes'=>array(
			// '<controller:page|user|layout|snippet|auth|asset>',
			'<controller:page|user|layout|snippet|auth|asset|setting>/<action:\w+>',
			'plugin/<plugin:\w+>/<controller:\w+>',
			'plugin/<plugin:\w+>/<controller:\w+>/<action:\w+>',
			'<path:.+>',
		),
	),
	'plugins'=>require_once(PLUGINS_CONFIG_FILE_PATH),
);