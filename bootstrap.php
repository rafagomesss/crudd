<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

define('DIR_ROOT', dirname($_SERVER['DOCUMENT_ROOT']));

define('ASSETS_PATH',  '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMG_PATH', ASSETS_PATH . '/img');
define('VIEWS_PATH', DIR_ROOT . '/views');
define('VIEWS_INCLUDES_PATH', DIR_ROOT . '/views/includes');
define('VIEWS_SITE_PATH', DIR_ROOT . '/views/site');
