<?php

$config=new Easysite\Library\Config;
use Easysite\Library\Config\Storage\StorageSession;
define("PATH_CONFIG", ROOT_PATH . 'config/');

$config->set('pathApplication',ROOT_PATH . 'application/');
$config->set('pathController',$config->get('pathApplication') . 'controllers/');
$config->set('viewPath',$config->get('pathApplication').'view/');
$config->set('session', new StorageSession(require_once PATH_CONFIG . 'session.php'));
$config->set('database',require_once PATH_CONFIG . 'database.php');
$config->set('redirect',require_once PATH_CONFIG . 'redirect.php');
$config->set('routs',require_once PATH_CONFIG . 'routs.php');
$config->set('languagesList',require_once PATH_CONFIG . 'lang.php');

var_dump($config->getAll());
