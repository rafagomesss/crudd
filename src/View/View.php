<?php
namespace Crud\View;

class View
{
    private $view;
    private $data = [];
    private $menu;

    public function __construct($view, $menu = false)
    {
        $this->view = $view;
        $this->menu = $menu;
        ob_start();
        require VIEWS_INCLUDES_PATH . '/header.phtml';
    }

    public function __set($index, $value)
    {
        $this->data[$index] = $value;
    }

    public function __get($index)
    {
        return $this->data[$index];
    }

    public function render()
    {
        require VIEWS_PATH . DIRECTORY_SEPARATOR . $this->view;
        require VIEWS_INCLUDES_PATH . '/footer.phtml';
        return ob_get_clean();
    }
}
