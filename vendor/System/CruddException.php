<?php
namespace System;

use Crud\View\View;

class CruddException extends \Exception
{
    const ERROR_LEVEL = [
        'danger' => 'ERRO!',
        'warning' => 'ATENÇÃO!',
        'success' => 'SUCESSO!'
    ];
    protected $title;
    protected $class;

    private function throwException()
    {
        $view = new View('error.phtml', true);
        $view->title = $this->title;
        $view->message = $this->message;
        $view->code = $this->code;
        $view->class = $this->class;
        print $view->render();
        exit();
    }

    public function __construct($title = 'success', $message = '', $code = 0)
    {
        $this->title = self::ERROR_LEVEL[$title];
        $this->message = $message;
        $this->code = $code;
        $this->class = $title;
        return $this->throwException();
    }
}
