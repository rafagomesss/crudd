<?php
namespace Crud\Controller;

use Crud\Model\ModelUser;
use Crud\View\View;
use System\Session\Session;

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
            return true;
        }
        return false;
    }

    public function validateLogin()
    {
        $param = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = $this->model->findBy($param);

        $response = [
            'erro' => true,
            'message' => 'Usuário não existe!',
            'redirect' => '/auth',
            'class' => 'warning'
        ];
        if (is_object($data)) {
            if ($this->validatePassword($data)) {
                Session::set('USER', $data->email);
                Session::set('ACCESS_LEVEL', $data->access_level_id);
                Session::set('success', 'Autenticação realizada com sucesso!');
                $response = [
                    'message' => 'Autenticação realizada com sucesso!',
                    'redirect' => '/',
                    'class' => 'success'
                ];
            } else {
                Session::destroy();
                $response = [
                    'erro' => true,
                    'message' => 'Senha inválida!',
                    'redirect' => '/auth',
                    'class' => 'warning'
                ];
            }
        }

        echo json_encode($response);
    }

    public function index()
    {
        $view = new View('authentication/login.phtml', true);
        $view->controller = 'auth';
        $view->viewName = 'login';
        return $view->render();
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
        $view->viewName = 'register';
        return $view->render();
    }

    public function register()
    {
        echo json_encode((new ModelUser())->insert());
    }
}
