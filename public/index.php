<?php
require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . "bootstrap.php";

use System\{
    Router,
    Constants
};
use System\Session\Session;

Session::start();
Router::validateRoute();
