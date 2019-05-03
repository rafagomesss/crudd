<?php
namespace Crud\Controller;

use Crud\View\View;
use Crud\Model\ModelUser;

class HomeController
{
    public function index()
    {
        $view = new View('site/index.phtml', true);
        return $view->render();
    }
}
