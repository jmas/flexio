<?php

return array(
	'status'=>Flexio::STATUS_DEV,
	'name'=>'Flexio',
	'theme'=>'null',
	'db'=>array(
		'dsn'=>'mysql:dbname=flexio;host=127.0.0.1',
	),
	'plugins'=>require_once(PLUGINS_CONFIG_FILE_PATH),
);