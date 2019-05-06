<?php
namespace System;

use Crud\View\View;

class CruddException extends \Exception
{
    const ERROR_LEVEL = [
        'error' => 'ERRO!',
        'danger' => 'ERRO!',
        'warning' => 'ATENÇÃO!',
        'success' => 'SUCESSO!'
    ];
    protected $title;
    protected $class;
    protected $ajax = false;

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

    public function __construct($title, $message, $code = 0, $ajax = false)
    {
        $this->title = self::ERROR_LEVEL[$title];
        $this->message = $message;
        $this->code = $code;
        $this->class = $title;
        if ($ajax) {
            return $this->throwExceptionAjax();
        }
        return $this->throwException();
    }

    private function throwExceptionAjax()
    {
        $data = [
            'erro' => true,
            'message' => $this->message,
            'classes' => $this->class
        ];
        echo json_encode($data);
        exit();
    }
}
