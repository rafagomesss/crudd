<?php
namespace System;

use Crud\View\View;
use PHPMailer\PHPMailer\PHPMailer;

class Email extends PHPMailer
{
    private function sendEmail()
    {
        if (!$this->send()) {
            echo json_encode(['erro' => true, 'message' => 'Erro durante o envio de e-mail: ' . $this->ErrorInfo]);
        } else {
            echo json_encode(['message' => 'E-mail enviado com sucesso!']);
        }
    }

    public function __construct(array $data)
    {
        ob_start();
        $view = new View('site/email/contact.phtml');
        $view->nome = $data['nome'];
        $view->email = $data['email'];
        $view->contato = $data['contato'];
        $view->mensagem = $data['mensagem'];
        return $view->render();
        $html = ob_get_clean();
        $this->isSMTP();
        $this->SMTPDebug = 2;
        $this->Host = 'smtp.gmail.com';
        $this->Port = 587;
        $this->SMTPSecure = 'tls';
        $this->SMTPAuth = true;
        $this->Username = '';
        $this->Password = '';
        $this->setFrom('', '');
        $this->addAddress($data['email'], $data['nome']);
        $this->Subject = 'PHPMailer GMail SMTP test';
        $this->msgHTML($html);
        // $this->addAttachment('images/phpmailer_mini.png');
        $this->sendEmail();
      

    }


}