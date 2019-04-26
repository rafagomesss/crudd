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
            $_SESSION['USER'] = $data->email;
            $_SESSION['ACCESS_LEVEL'] = $data->access_level_id;
            header('Location: /user/list');
        } else {
            unset($_SESSION);
            header('Location: /auth');
        }
    }

    public function index()
    {
        return (new View('site/login.phtml', true))->render();
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
}
