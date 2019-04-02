<?php
namespace Crud\Controller;

use Crud\View\View;

class AboutController
{
	public function index()
	{
		$view = new View('site/about.phtml', true);
		return $view->render();
	}
}
