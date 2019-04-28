<?php
namespace System;

use System\Session\Session;

class Router
{
	private static function getUrl()
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

	private static function restrictRoute()
	{
		extract(self::getUrl());
		if (in_array($controller, Constants::RULE_ROUTE_SESSION) && is_null(Session::get('USER'))) {
			print (new \Crud\View\View('/404.phtml'))->render();
			exit();
		}
	}

	public static function validateRoute()
	{
		extract(self::getUrl());
		self::restrictRoute();
		if(!class_exists($controller = "Crud\Controller\\" . ucfirst($controller) . 'Controller'))
		{
			print (new \Crud\View\View('/404.phtml'))->render();
			exit();
		}

		if(!method_exists($controller, $action)) {
			$action = 'index';
			$param  = $action;
		}

		$response = call_user_func_array([new $controller, $action], [$param]);
		print $response;
	}
}
