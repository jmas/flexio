<?php

define('START_TIME', microtime());

require_once('classes/App.php');

App::instance()->run();

echo microtime() - START_TIME;