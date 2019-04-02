<?php
namespace System;

class Router
{
	private function getUrl()
	{
		$uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
		$uri = explode('/', $uri);

		$retorno = [
			'controller' => isset($uri[0]) && $uri[0] ? $uri[0] : 'home',
			'action' => isset($uri[1]) && $uri[1] ? $uri[1] : 'index',
			'param' => isset($uri[2]) && $uri[2] ? $uri[2] : []
		];

		return $retorno;
	}

	public static function validarRota()
	{

		extract(self::getUrl());

		if(!class_exists($controller = "Crud\Controller\\" . ucfirst($controller) . 'Controller'))
		{
			print (new \Crud\View\View('/404.phtml'))->render();
			die;
		}

		if(!method_exists($controller, $action)) {
			$action = 'index';
			$param  = $action;
		}

		$response = call_user_func_array([new $controller, $action], [$param]);
		print $response;
	}
}