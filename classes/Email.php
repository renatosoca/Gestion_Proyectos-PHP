<?php
namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $tokne;

    function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        $mail = new PHPMailer();

        //CONFIG SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->Username = '4a8895ebea0bc9';
        $mail->Password = 'a24423000737a7';
        $mail->SMTPSecure = 'tls';

        //CONTENIDO DEL EMAIL
        $mail->setFrom('admin@uptask.com');
        $mail->addAddress('rena@gmail.com','uptask.com');
        $mail->Subject = 'Confirma tu cuenta';
        
        //HABILITAR HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        //DEFINIR CONTENIDO
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en UpTask, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token ."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es Texto Alternativo sin HTML';

        //ENVIAR EMAIL
        $mail->send();
    }

    public function enviarInstrucciones() {

        $mail = new PHPMailer();

        //CONFIG SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->Username = '4a8895ebea0bc9';
        $mail->Password = 'a24423000737a7';
        $mail->SMTPSecure = 'tls';

        //CONTENIDO DEL EMAIL
        $mail->setFrom('admin@appsalon.com');
        $mail->addAddress('rena@gmail.com','AppSalon.com');
        $mail->Subject = 'Reestablece tu Contraseña';
        
        //HABILITAR HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        //DEFINIR CONTENIDO
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu Contraseña, sigue el siguiente enlace para reestablecer tu contraseña</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token ."'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es Texto Alternativo sin HTML';

        //ENVIAR EMAIL
        $resultado = $mail->send();
        return $resultado;
    }
}