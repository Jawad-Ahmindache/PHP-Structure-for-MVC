<?php
session_start();

require __DIR__."/Utils/"."r2i-config.php";

require_once __DIR__."/vendor/autoload.php";

require __R2ICORE__."/Controller/App.php";


require 'test.php';
die();


$_APP = \App::getInstance();

$_APP->start();

$_APP->render();



