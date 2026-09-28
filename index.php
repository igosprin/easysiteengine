<?php
define('ROOT_PATH', dirname( __FILE__). '/');
require ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'config.php';
header("Content-Type: text/html;charset=utf-8");
Easysite\Library\ErrorHandler::register();

$app = new Easysite\Library\Application\Http(
    [
        '\Easysite\Library\Instance\FileManager',
        '\Easysite\Library\Instance\Session',
        '\Easysite\Library\Instance\Cache'
    ]
);
$app->init();

