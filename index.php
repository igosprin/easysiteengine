<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_NOTICE);

define('ROOT_PATH', dirname(__FILE__) . '/');
require_once ROOT_PATH . 'config.php';
require ROOT_PATH . 'vendor/autoload.php';


$app = new Easysite\Library\Application(PATH_CONTROLLER, PATH_VIEW, ROUTS, LANGUAGES);
$app->init();


