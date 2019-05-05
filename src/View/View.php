<?php
namespace Crud\View;

use System\Router;

class View
{
    private $view;
    private $menu;

    public function __construct($view, $menu = false)
    {
        $this->view = VIEWS_PATH . DIRECTORY_SEPARATOR . $view;
        $this->menu = $menu;
    }

    public function __set($index, $value)
    {
        $this->{$index} = $value;
    }

    public function __get($index)
    {
        return $this->{$index};
    }

    public function render()
    {
        ob_start();
        if (is_file($this->view)) {
            require VIEWS_INCLUDES_PATH . '/header.phtml';
            require $this->view;
            require VIEWS_INCLUDES_PATH . '/footer.phtml';
        } else {
            Router::notFound();
        }
        return ob_get_clean();
    }
}
