<?php
namespace Crud\Controller;

use Crud\View\View;

class ReportController
{
    private $model;

    public function __construct()
    {
    }

    public function reportData(string $type)
    {
        $view = new View("site/report/{$type}.phtml", true);
        $view->controller = 'report';
        $view->type = $type;
        return $view->render();
    }
}
