<?php
require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . "bootstrap.php";

use System\Router;
use System\Constants;
use System\Session\Session;

Session::start();
(new Router)->validateRoute();
