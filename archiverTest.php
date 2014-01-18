<?php

require_once('classes/Archiver.php');

$archiver = new Archiver();

var_dump( $archiver->pack('./', './assets/dump.zip') );

var_dump( $archiver->getOutput() );