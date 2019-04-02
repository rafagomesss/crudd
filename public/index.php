<?php
require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . "bootstrap.php";

use System\Router;

Router::validarRota();
