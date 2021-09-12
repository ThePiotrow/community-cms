<?php

namespace App\Core;

use App\Core\PHPMailer\PHPMailer;
use App\Core\PHPMailer\SMTP;

class Mailer
{
    public static function mail(array $from, array $to, $subject, $body, $altBody = "")
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;

        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';

        $mail->setFrom($from['address'], $from['name'] ?? '');

        $mail->addAddress($to['address'], $to['name'] ?? $to['address']);

        $mail->Subject = $subject;
        $mail->msgHTML($body);
        $mail->AltBody = $altBody;

        $mail->send();
    }
}
