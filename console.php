<?php
define('ROOT_PATH', dirname(__FILE__) . '/');
require ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'config.php';
Easysite\Library\ErrorHandler::register(cli: true);

$console = new Easysite\Library\Application\Console(
    [
        '\Easysite\Library\Instance\FileManager',
        '\Easysite\Library\Instance\Cache'
    ],
    $argv
);
$console->init();
