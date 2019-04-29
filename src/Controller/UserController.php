<?php
namespace Crud\Controller;

use Crud\Controller\UserController;
use Crud\View\View;
use Crud\Model\ModelUser;
use Crud\Model\ModelAccessLevel;

class UserController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ModelUser();
    }

    public function index()
    {
        return $this->list();
    }

    public function list()
    {
        $view = new View('site/user/list.phtml', true);
        $view->controller = 'user';
        $view->users = $this->model->executeProcedureReturbale('listUserAccess');
        return $view->render();
    }

    public function register()
    {
        $view = new View('site/user/register.phtml', true);
        $view->controller = 'user';
        $view->viewName = 'register';
        $view->accessLevels = (new ModelAccessLevel())->findAll();
        return $view->render();
    }

    public function edit($id)
    {
        $view = new View('site/user/edit.phtml', true);
        $view->controller = 'user';
        $view->user = $this->model->find($id);
        $view->accessLevels = (new ModelAccessLevel())->findAll();
        return $view->render();
    }

    public function insert()
    {
        echo json_encode($this->model->insert());
    }

    public function delete()
    {
        echo json_encode($this->model->delete());
    }

    public function update()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        echo json_encode($this->model->update($data));
    }
}
