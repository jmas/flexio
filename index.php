<?php

date_default_timezone_set('UTC');

// define('START_TIME', microtime());

require_once('classes/Flexio.php');

Flexio::app()->run();

// echo microtime() - START_TIME;