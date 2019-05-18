<?php
namespace Crud\Controller;

use Crud\View\View;
use System\Email;

class ContactController
{
    public function index()
    {
        $view = new View('site/contact.phtml', true);
        $view->controller = 'contact';
        return $view->render();
    }

    public function sendEmailContact()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        (new Email($data));
    }

    public function table()
    {
        $view = new View('site/email/contact.phtml', true);
        return $view->render();
    }
}