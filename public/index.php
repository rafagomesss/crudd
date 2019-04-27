<?php
require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . "bootstrap.php";

use System\{
    Router,
    Session,
    Constants
};

Session::start();
Router::validateRoute();
