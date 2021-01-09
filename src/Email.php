<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class Email
{

    public static function enviarEmail($destinatario, $assunto, $mensagem)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF; 
            $mail->CharSet = PHPMailer::CHARSET_UTF8;                      // Enable verbose debug output
            $mail->isSMTP();                                          // Send using SMTP
            $mail->Host       = 'comprebilhete.com.br';               // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
            $mail->Username   = 'atendimento@comprebilhete.com.br';   // SMTP username
            $mail->Password   = 'Swxaqz33';                           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 465;                                  // TCP port to connect to

            //Recipients
            $mail->setFrom('atendimento@comprebilhete.com.br', 'Compre Bilhete'); // Remetente
            $mail->addAddress($destinatario, $destinatario);       // Destinatário

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}