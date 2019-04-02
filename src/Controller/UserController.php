<?php
namespace Crud\Controller;

use Crud\Controller\UserController,
	Crud\View\View;

class UserController
{
	public function __construct()
	{
		
	}

	public function register()
	{
		$view = new View('site/user/register.phtml', true);
		return $view->render();
	}
}
