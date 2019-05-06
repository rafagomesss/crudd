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

    public function insert()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        echo json_encode($this->model->insert($data));
    }

    public function update()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        echo json_encode($this->model->update($data));
    }

    public function list()
    {
        $view = new View('site/category/list.phtml', true);
        $view->controller = 'category';
        $view->categories = $this->model->findAll();
        return $view->render();
    }

    public function edit($id)
    {
        $view = new View('site/category/edit.phtml', true);
        $view->controller = 'category';
        $view->category = $this->model->find($id);
        return $view->render();
    }

    public function delete()
    {
        echo json_encode($this->model->delete());
    }
}