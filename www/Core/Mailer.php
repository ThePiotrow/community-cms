<?php

namespace App\Core;

use App\Core\PHPMailer\PHPMailer;
use App\Core\PHPMailer\SMTP;

class Mailer
{
    public static function init(array $from, array $to, $subject, $body, $altBody = "")
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'ssl0.ovh.net';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@la11eme.fr';
        $mail->Password = 'azertyuiop';

        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';

        $mail->setFrom($from['address'], $from['name'] ?? '');

        foreach ($to as $receiver) {
            $mail->addAddress($receiver['address'], $receiver['address'] ?? '');
        }

        $mail->Subject = $subject;
        $mail->msgHTML($body);
        $mail->AltBody = $altBody;

        return $mail;
    }

    public static function sendEmail($mailObject, $onSuccess = null, $onError = null)
    {
        $sent = $mailObject->send();

        if ($sent) {
            if ($onSuccess)
                $onSuccess();
        } else {
            if ($onError)
                $onError();
        }
    }
}
