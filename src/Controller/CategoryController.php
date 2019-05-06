<?php
namespace Crud\Controller;

use Crud\Model\ModelCategory;
use Crud\View\View;

class CategoryController
{
    public function __construct()
    {
        $this->model = new ModelCategory();
    }

    public function register()
    {
        $view = new View('site/category/register.phtml', true);
        $view->controller = 'category';
        $view->viewName = 'register';
        return $view->render();
    }
}