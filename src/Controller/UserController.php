<?php
namespace Crud\Controller;

use Crud\{
	Controller\UserController,
	View\View,
	Model\ModelUser
};

class UserController
{
	protected $model;

	public function __construct()
	{
		$this->model = new ModelUser();
	}

	public function list()
	{
		$view = new View('site/user/list.phtml', true);
		$view->controller = 'user';
		$view->users = $this->model->findAll();
		return $view->render();
	}

	public function register()
	{
		$view = new View('site/user/register.phtml', true);
		$view->controller = 'user';
		$view->viewName = 'register';
		return $view->render();
	}

	public function edit($id)
	{
		$view = new View('site/user/edit.phtml', true);
		$view->controller = 'user';
		$view->viewName = 'edit';
		$view->user = $this->model->find($id);
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
		$retorno = $this->model->update($data);
		if(!array_key_exists('erro', $retorno)) {
			header('Location: /user/list');
		}
	}
}
