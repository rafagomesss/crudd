<?php
namespace Crud\Controller;

use Crud\Controller\UserController;
use Crud\Model\ModelAccessLevel;
use Crud\Model\ModelUser;
use Crud\View\View;
use System\Common;
use System\Constants;
use System\PasswordManager;

class UserController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ModelUser();
    }

    private function filterUserData(): array
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = Common::removeEmptyValueArray($data);
        $data['password'] = PasswordManager::passwordHash($data['password']);
        if (array_key_exists('confirmPassword', $data)) {
            unset($data['confirmPassword']);
        }
        return $data;
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
        $data = $this->filterUserData();
        echo json_encode($this->model->update($data));
    }
}
