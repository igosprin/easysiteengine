<?php
define('ROOT_PATH', dirname( __FILE__). '/');
require ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'config.php';

header("Content-Type: text/html;charset=utf-8");
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_NOTICE);



$app = new Easysite\Library\Application($config);
$app->init();


