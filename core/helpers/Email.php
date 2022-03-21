<?php
namespace core\helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    /**
     * @param string $emailClient
     * @return bool 
    */
    public function sendEmail(string $emailClient): bool {

        $mail = new PHPMailer(true);

        try {
            
            // Server config
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // Emissor e recebedor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($emailClient);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = 'Seu email foi cadastrado!';

            // Messagem
            $html = "<p>$emailClient, você foi cadastrado em nosso sistema!</p>";

            $mail->Body = $html;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $message
     * @return bool 
    */
    public static function sendEmailContactPage(string $name, string $email, string $phone, string $message): bool {

        $mail = new PHPMailer(true);

        try {
            
            // Server config
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // Emissor e recebedor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress(EMAIL_FROM);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = "Formulário de contato do site ".APP_NAME."!";

            // Messagem
            $html = "<h3>Nova dúvida do site enviada pelo $name.</h3>";
            $html .= "<p>Telefone de contato: $phone</p>";
            $html .= "<p>Email de contato: $email</p>";
            $html .= "<p>$message</p>";

            $mail->Body = $html;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $emailClient
     * @return bool 
    */
    public static function sendEmailFromClientInfoStatusPending(string $emailClient, $body): bool {

        $mail = new PHPMailer(true);

        try {
            
            // Server config
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // Emissor e recebedor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($emailClient);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = 'Pagamento pendente!';

            // Messagem
            $html = $body;

            $mail->Body = $html;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

}