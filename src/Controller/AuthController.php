<?php
namespace Crud\Controller;

use Crud\Model\ModelUser;
use Crud\View\View;
use System\Common;
use System\PasswordManager;
use System\Session\Session;

class AuthController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ModelUser();
    }

    private function authenticateUser($email)
    {
        $user = current($this->model->executeProcedureReturbale('getUserAccess', [$email]));
        Session::set('USER_ID', $user->id);
        Session::set('USER', $user->email);
        Session::set('USER_NAME', $user->name);
        Session::set('ACCESS_LEVEL', $user->level);
        Session::set('success', 'Autenticação realizada com sucesso!');
    }

    public function validateLogin()
    {
        $param = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = $this->model->findBy($param);

        $response = [
            'erro' => true,
            'message' => 'Usuário não existe!',
            'redirect' => '/auth',
            'class' => 'warning',
        ];
        if (is_object($data)) {
            if (PasswordManager::validatePassword($param['password'], $data->password)) {
                $this->authenticateUser($data->email);
                $response = [
                    'message' => 'Autenticação realizada com sucesso!',
                    'redirect' => '/',
                    'class' => 'success',
                ];
            } else {
                Session::destroySession();
                $response = [
                    'erro' => true,
                    'message' => 'Senha inválida!',
                    'redirect' => '/auth',
                    'class' => 'warning',
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
        Session::destroySession();
        (new Session)->start();
        Session::set('success', 'Usuário foi deslogado com sucesso!');
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
        try {
            $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data['password'] = PasswordManager::passwordHash($data['password']);
            unset($data['confirmPassword']);
            $data['birthdate'] = Common::convertDateToDataBase($data['birthdate']);
            $insert = current($this->model->executeProcedureReturbale('userRegister', $data));
            if ((int) $insert->user_access_id > 0 && (int) $insert->user_id > 0) {
                $retorno = ['message' => 'Registro salvo com sucesso!'];
            }
        } catch (Exception $e) {
            $retorno = ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
        }
        echo json_encode($retorno);
    }
}
