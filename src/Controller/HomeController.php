<?php
namespace Crud\Controller;

use Crud\View\View,
	Crud\Model\ModelUsuario;

class HomeController
{
	public function index()
	{
		$view = new View('site/index.phtml', true);
		$view->users = (new ModelUsuario())->findAll();
		return $view->render();
	}
}
