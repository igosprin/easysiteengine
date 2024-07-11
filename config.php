<?php
define("PATH_APPLICATION", ROOT_PATH . 'application/');
define("PATH_LIBRARY", PATH_APPLICATION . 'library/');
define("PATH_CONTROLLER", PATH_APPLICATION . 'controllers/');
define("PATH_CONFIG", ROOT_PATH . 'config/');
define("PATH_VIEW", PATH_APPLICATION . 'view/');
define("DB_CONFIG", require_once PATH_CONFIG . 'database.php');
define("REDIRECT", require_once PATH_CONFIG . 'redirect.php');
define("REQUEST_URI", $_SERVER['REQUEST_URI']);
define("ROUTS", require_once PATH_CONFIG . 'routs.php');
define("LANGUAGES", require_once PATH_CONFIG . 'lang.php');

