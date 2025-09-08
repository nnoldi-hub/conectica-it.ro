<?php
require_once __DIR__ . '/../config/mail.php';

/**
 * SimpleMailer: HTML email via PHP mail() using correct headers.
 * On many shared hosts, mail() relays through authenticated local MTA.
 * If you need SMTP auth, set up PHPMailer via Composer and swap implementation.
 */
class SimpleMailer {
    private $from; private $fromName;
    public function __construct() {
        $this->from = MAIL_FROM;
        $this->fromName = MAIL_FROM_NAME;
    }
    public function send($toEmail, $toName, $subject, $html, $text = '') {
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                // SMTP if password present, else use mail()
                if (defined('SMTP_PASS') && SMTP_PASS !== '') {
                    $mail->isSMTP();
                    $mail->Host = SMTP_HOST;
                    $mail->Port = SMTP_PORT;
                    $mail->SMTPAuth = true;
                    if (defined('SMTP_SECURE') && SMTP_SECURE === 'ssl') {
                        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    } elseif (defined('SMTP_SECURE') && SMTP_SECURE === 'tls') {
                        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    }
                    $mail->Username = SMTP_USER;
                    $mail->Password = SMTP_PASS;
                }
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($this->from, $this->fromName);
                $mail->addAddress($toEmail, $toName ?: $toEmail);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $html;
                if ($text) { $mail->AltBody = $text; }
                if (defined('SMTP_PASS') && SMTP_PASS !== '') {
                    return $mail->send();
                } else {
                    // fallback to mail() transport
                    $mail->isMail();
                    return $mail->send();
                }
            } catch (Throwable $e) {
                // fall through to basic mail()
            }
        }
        $boundary = uniqid('np');
        $headers = [];
        $headers[] = 'From: ' . $this->fromName . ' <' . $this->from . '>';
        $headers[] = 'Reply-To: ' . $this->from;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multipart/alternative;boundary=' . $boundary;

        $altText = $text ?: strip_tags(str_replace(['<br>','<br/>','<br />'], "\n", $html));
        $message = "--$boundary\r\n";
        $message .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
        $message .= $altText . "\r\n";
        $message .= "--$boundary\r\n";
        $message .= "Content-Type: text/html; charset=utf-8\r\n\r\n";
        $message .= $html . "\r\n";
        $message .= "--$boundary--";

        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        return @mail($toEmail, $encodedSubject, $message, implode("\r\n", $headers));
    }
}
?>