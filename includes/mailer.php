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