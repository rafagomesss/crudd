<?php
require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . "bootstrap.php";

use System\CruddException;
use System\Router;
use System\Session\Session;

(new Session)->start();
(new Router)->run();

echo 'final';
