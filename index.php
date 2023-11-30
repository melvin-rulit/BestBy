<?php

date_default_timezone_set('Europe/Moscow');

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SITE_PATH', DOCUMENT_ROOT . '/');
define('CLASSES', DOCUMENT_ROOT . '/protected/classes/');
define('CONTROLLERS', DOCUMENT_ROOT . '/protected/controllers/');
define('MODULES', DOCUMENT_ROOT . '/protected/modules/');
//define('SUBSYSTEM', DOCUMENT_ROOT . '/protected/subsystem/');
//define('LIBRARY', DOCUMENT_ROOT . '/protected/libraries/');






//require_once(SITE_PATH . 'protected/libraries/redirect.php');
require_once(SITE_PATH . 'protected/config.php');
require_once(SITE_PATH . 'vendor/autoload.php');
require_once(CLASSES . 'initializer.php');