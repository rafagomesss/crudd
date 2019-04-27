<?php
namespace Crud\Controller;

use Crud\{
    Model\ModelUser,
    View\View
};
use System\Session;

class AuthController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ModelUser();
    }

    private function validatePassword(\stdClass $data): bool
    {
        if (password_verify(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), $data->password)) {
            Session::set('USER', $data->email);
            Session::set('ACCESS_LEVEL', $data->access_level_id);
            header('Location: /user/list');
        } else {
            Session::destroy();
            header('Location: /auth');
        }
    }

    public function index()
    {
        return (new View('authentication/login.phtml', true))->render();
    }

    public function validateLogin()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $retorno = $this->model->findBy($data);
        if ($retorno) {
            $this->validatePassword($retorno);
        } else {
            header('Location: /auth');
        }
    }

    public function logout()
    {
        Session::destroy();
        header('Location: /');
    }

    public function createAccount()
    {
        $view = new View('authentication/register.phtml', true);
        $view->controller = 'auth';
        return $view->render();
    }

    public function register()
    {
        echo json_encode((new ModelUser())->insert());
    }
}
