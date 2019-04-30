<?php
namespace System;

use System\Session\Session;

class Router
{
	private $controller;
	private $action;
	private $param = [];

	public function __construct()
	{
		$this->getUrl();
	}

	private function getUrl()
	{
		$uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
		$uri = explode('/', $uri);

		$this->controller = isset($uri[0]) && $uri[0] ? $uri[0] : 'home';
		$this->action = isset($uri[1]) && $uri[1] ? $uri[1] : 'index';
		$this->param = isset($uri[2]) && $uri[2] ? $uri[2] : [];
	}

	private function notFound()
	{
		print (new \Crud\View\View('/404.phtml', true))->render();
		exit();
	}

	private function restrictRouteSession()
	{
		if (in_array($this->controller, Constants::RULE_ROUTE_SESSION) && !Session::has('USER')) {
			return false;
		}
		return true;
	}

	private function restrictRouteUser()
	{
		if (Session::validateSessionUser()) {
			if (in_array($this->controller, Constants::RESTRICT_USER[Session::get('ACCESS_LEVEL')]['controller']) && in_array($this->action, Constants::RESTRICT_USER[Session::get('ACCESS_LEVEL')]['methods'])) {
				return false;
			}
		}
		return true;
	}

	public function validateRoute()
	{
		if (!$this->restrictRouteSession() || !$this->restrictRouteUser()) {
			$this->notFound();
		}

		if(!class_exists($this->controller = "Crud\Controller\\" . ucfirst($this->controller) . 'Controller'))
		{
			print (new \Crud\View\View('/404.phtml', true))->render();
			exit();
		}

		if(!method_exists($this->controller, $this->action)) {
			$this->action = 'index';
			$param  = $this->action;
		}

		$response = call_user_func_array([new $this->controller, $this->action], [$this->param]);
		print $response;
	}
}
