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
        $uri = parse_url(substr($_SERVER['REQUEST_URI'], 1), PHP_URL_PATH);
        $uri = explode('/', $uri);

        $this->controller = isset($uri[0]) && $uri[0] ? $uri[0] : 'home';
        $this->action = isset($uri[1]) && $uri[1] ? $uri[1] : 'index';
        $this->param = isset($uri[2]) && $uri[2] ? $uri[2] : [];
    }

    private function notFound()
    {
        print(new \Crud\View\View('/404.phtml', true))->render();
        exit();
    }

    private function controlRestrictedRoutes()
    {
        if (Session::validateSessionUser() && isset(Constants::RESTRICT_USER_ROUTE[Session::get('ACCESS_LEVEL')])) {
            if (in_array($this->controller, array_keys(Constants::RESTRICT_USER_ROUTE[Session::get('ACCESS_LEVEL')]['controller'])) && in_array($this->action, Constants::RESTRICT_USER_ROUTE[Session::get('ACCESS_LEVEL')]['controller'][$this->controller]['action'])) {
                $this->notFound();
            }
        }
    }

    private function restrictRoute()
    {
        if (in_array($this->controller, Constants::RULE_ROUTE_SESSION) && !Session::validateSessionUser()) {
            $this->notFound();
        }
    }

    private function validateRoute()
    {
        if (!class_exists($this->controller = "Crud\Controller\\" . ucfirst($this->controller) . 'Controller')) {
            $this->notFound();
        }

        if (!method_exists($this->controller, $this->action)) {
            $this->action = 'index';
            $this->param = $this->action;
        }

        $response = call_user_func_array([new $this->controller, $this->action], [$this->param]);
        print $response;
    }

    public function run()
    {
        $this->restrictRoute();
        $this->controlRestrictedRoutes();
        $this->validateRoute();
    }
}
