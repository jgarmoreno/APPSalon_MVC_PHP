<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this -> email = $email;
        $this -> nombre = $nombre;    
        $this -> token = $token;

    }
    public function enviarConfirmacion(){
        // Crea el objeto
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Datos
        $mail->setFrom('soporte@appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta en AppSalon';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        
        // Contenido
        $mail->Body = "
        <html>
            <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
            h2 {
                font-size: 25px;
                font-weight: 500;
                line-height: 25px;
            }
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #ffffff;
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
            }
            p {
                line-height: 18px;
            }
            a {
                position: relative;
                z-index: 0;
                display: inline-block;
                margin: 20px 0;
            }
            a button {
                padding: 0.7em 2em;
                font-size: 16px !important;
                font-weight: 500;
                background: #000000;
                color: #ffffff;
                border: none;
                text-transform: uppercase;
                cursor: pointer;
            }
            p span {
                font-size: 12px;
            }
            div p{
                border-bottom: 1px solid #000000;
                border-top: none;
                margin-top: 40px;
            }
            </style>
            <body>
                <h1>AppSalon</h1>
                <h2>¡Gracias por registrarte!</h2>
                <p>Por favor confirma tu correo electrónico para que puedas comenzar a disfrutar de todos los servicios de AppSalon</p>
                <a href='" . $_ENV['APP_URL']  . "/confirmar-cuenta?token=" . $this->token . "'><button>Verificar</button></a>
                <p>Si tú no te registraste en AppSalon, por favor ignora este correo electrónico.</p>
                <div><p></p></div>
                <p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>
            </body>
        </html>";
        // Enviar el email
        $mail -> send();
    }
    public function enviarResetPassword(){
        // Crea el objeto
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Datos
        $mail->setFrom('soporte@appsalon');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta en AppSalon';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        
        // Contenido
        $mail->Body = "
        <html>
            <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
            h2 {
                font-size: 25px;
                font-weight: 500;
                line-height: 25px;
            }
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #ffffff;
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
            }
            p {
                line-height: 18px;
            }
            a {
                position: relative;
                z-index: 0;
                display: inline-block;
                margin: 20px 0;
            }
            a button {
                padding: 0.7em 2em;
                font-size: 16px !important;
                font-weight: 500;
                background: #000000;
                color: #ffffff;
                border: none;
                text-transform: uppercase;
                cursor: pointer;
            }
            p span {
                font-size: 12px;
            }
            div p{
                border-bottom: 1px solid #000000;
                border-top: none;
                margin-top: 40px;
            }
            </style>
            <body>
                <h1>AppSalon</h1>
                <h2>Reestablece tu contraseña</h2>
                <p>Hola, $this->nombre. Para poder recuperar tu cuenta y crear una nueva contraseña, haz click en el enlace inferior.</p>
                <a href='" . $_ENV['APP_URL']  . "/recuperar-cuenta?token=" . $this->token . "'><button>Reestablecer</button></a>
                <p>Si tú no solicitaste un reestablecimiento de tu contraseña en AppSalon, por favor ignora este correo electrónico.</p>
                <div><p></p></div>
                <p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>
            </body>
        </html>";
        // Enviar el email
        $mail -> send();
    }
}