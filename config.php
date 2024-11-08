<?php

use Easysite\Library\Config;
use Easysite\Library\Config\ConfigSession;
use Easysite\Library\Config\ConfigCache;

define("PATH_CONFIG", ROOT_PATH . 'config/');

Config::set('pathApplication',ROOT_PATH . 'application/');
Config::set('pathController',Config::get('pathApplication') . 'controllers/');
Config::set('viewPath',Config::get('pathApplication').'view/');
Config::set('session', new ConfigSession(require_once PATH_CONFIG . 'session.php'));
Config::set('database',require_once PATH_CONFIG . 'database.php');
Config::set('redirect',require_once PATH_CONFIG . 'redirect.php');
Config::set('routs',require_once PATH_CONFIG . 'routs.php');
Config::set('languagesList',require_once PATH_CONFIG . 'lang.php');
Config::set('cache',new ConfigCache(require_once PATH_CONFIG . 'cache.php'));
Config::set('storage',require_once PATH_CONFIG . 'storage.php');
