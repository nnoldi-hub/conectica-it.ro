<?php
// Load mail configuration gracefully (optional files) and define defaults
// Prefer CONFIG_PATH from init.php; fallback to local ../config
$__cfgDir = defined('CONFIG_PATH') ? CONFIG_PATH : realpath(__DIR__ . '/../config');
if ($__cfgDir && is_dir($__cfgDir)) {
    if (file_exists($__cfgDir . '/mail.php')) { require_once $__cfgDir . '/mail.php'; }
    if (file_exists($__cfgDir . '/mail.local.php')) { require_once $__cfgDir . '/mail.local.php'; }
}
// Defaults if not provided by config
if (!defined('MAIL_FROM')) { define('MAIL_FROM', 'no-reply@localhost'); }
if (!defined('MAIL_FROM_NAME')) { define('MAIL_FROM_NAME', 'Conectica-IT'); }
if (!defined('SMTP_HOST')) { define('SMTP_HOST', 'localhost'); }
if (!defined('SMTP_PORT')) { define('SMTP_PORT', 587); }
if (!defined('SMTP_SECURE')) { define('SMTP_SECURE', 'tls'); }
if (!defined('SMTP_USER')) { define('SMTP_USER', ''); }
if (!defined('SMTP_PASS')) { define('SMTP_PASS', ''); }

/**
 * SimpleMailer: HTML email via PHP mail() using correct headers.
 * On many shared hosts, mail() relays through authenticated local MTA.
 * If you need SMTP auth, set up PHPMailer via Composer and swap implementation.
 */
class SimpleMailer {
    private $from; private $fromName; private $lastError = '';
    public function __construct() {
        $this->from = defined('MAIL_FROM') ? MAIL_FROM : 'no-reply@localhost';
        $this->fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Conectica-IT';
    }
    public function getLastError() { return $this->lastError; }
    private function smtpSendRaw($toEmail, $data) {
        $host = SMTP_HOST; $port = (int)SMTP_PORT; $secure = strtolower((string)SMTP_SECURE);
        $user = (string)SMTP_USER; $pass = (string)SMTP_PASS;
        $errno = 0; $errstr = '';
        $remote = ($secure === 'ssl' ? "ssl://$host" : $host) . ':' . $port;
        $ctx = stream_context_create([ 'ssl' => [ 'verify_peer' => false, 'verify_peer_name' => false ] ]);
        $fp = @stream_socket_client($remote, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) { $this->lastError = 'Conexiune SMTP eșuată: ' . $errstr; return false; }
        stream_set_timeout($fp, 15);
        $read = function() use ($fp) { $line = ''; while (!feof($fp)) { $l = fgets($fp, 512); if ($l===false) break; $line .= $l; if (strlen($l) < 4) break; if (preg_match('~^\d{3}\s~', $l)) break; if (!preg_match('~^\d{3}-~', $l)) break; } return $line; };
        $write = function($cmd) use ($fp) { fwrite($fp, $cmd."\r\n"); };
        $expect = function($code) use ($read) { $resp = $read(); if (!preg_match('~^'.preg_quote((string)$code,'~').'~', $resp)) { return [false,$resp]; } return [true,$resp]; };
        $resp = $read();
        $write('EHLO conectica-it.ro'); list($ok,$resp) = $expect(250); if(!$ok && stripos($resp,'502')!==false){ $write('HELO conectica-it.ro'); list($ok,$resp) = $expect(250);} if(!$ok){ fclose($fp); $this->lastError = 'EHLO/HELO eșuat: '.trim($resp); return false; }
        if ($secure === 'tls') {
            $write('STARTTLS'); list($ok,$resp) = $expect(220); if(!$ok){ fclose($fp); $this->lastError = 'STARTTLS eșuat: '.trim($resp); return false; }
            if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { fclose($fp); $this->lastError = 'Handshake TLS eșuat'; return false; }
            $write('EHLO conectica-it.ro'); list($ok,$resp) = $expect(250); if(!$ok){ fclose($fp); $this->lastError = 'EHLO post-TLS eșuat: '.trim($resp); return false; }
        }
        if ($user !== '' || $pass !== '') {
            $write('AUTH LOGIN'); list($ok,$resp) = $expect(334); if(!$ok){ fclose($fp); $this->lastError = 'AUTH LOGIN resp invalid: '.trim($resp); return false; }
            $write(base64_encode($user)); list($ok,$resp) = $expect(334); if(!$ok){ fclose($fp); $this->lastError = 'AUTH user resp invalid: '.trim($resp); return false; }
            $write(base64_encode($pass)); list($ok,$resp) = $expect(235); if(!$ok){ fclose($fp); $this->lastError = 'AUTH parolă resp invalid: '.trim($resp); return false; }
        }
        $fromAddr = preg_match('/<([^>]+)>/', $data['From']??'', $m) ? $m[1] : $this->from;
        $write('MAIL FROM:<'.$fromAddr.'>'); list($ok,$resp) = $expect(250); if(!$ok){ fclose($fp); $this->lastError = 'MAIL FROM eșuat: '.trim($resp); return false; }
        $write('RCPT TO:<'.$toEmail.'>'); list($ok,$resp) = $expect(250); if(!$ok){ fclose($fp); $this->lastError = 'RCPT TO eșuat: '.trim($resp); return false; }
        $write('DATA'); list($ok,$resp) = $expect(354); if(!$ok){ fclose($fp); $this->lastError = 'DATA eșuat: '.trim($resp); return false; }
        // Build DATA payload
        $lines = [];
        foreach ($data as $k=>$v) { if ($k==='Body') continue; $lines[] = $k.': '.$v; }
        $lines[] = '';
        $body = str_replace(["\r\n","\r"], "\n", $data['Body']);
        $body = preg_replace('~\n\.~', "\n..", $body); // dot-stuffing
        $lines[] = $body;
        $payload = implode("\r\n", $lines) . "\r\n.";
        fwrite($fp, $payload."\r\n");
        list($ok,$resp) = $expect(250); if(!$ok){ fclose($fp); $this->lastError = 'Trimitere DATA eșuată: '.trim($resp); return false; }
        $write('QUIT');
        fclose($fp);
        return true;
    }
    public function send($toEmail, $toName, $subject, $html, $text = '') {
        $mailAvailable = function_exists('mail');
        // Prefer PHPMailer if available; gracefully fall back to mail()
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                // Transport selection: SMTP when password provided, else local mail transport
                $useSmtp = (defined('SMTP_PASS') && trim((string)SMTP_PASS) !== '');
                if ($useSmtp) {
                    $mail->isSMTP();
                    $mail->Host = SMTP_HOST;
                    $mail->Port = SMTP_PORT;
                    $mail->SMTPAuth = true;
                    if (isset($GLOBALS['SMTP_SECURE'])) { /* no-op to silence analyzers about constant checks */ }
                    if (defined('SMTP_SECURE') && SMTP_SECURE === 'ssl') {
                        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    } elseif (defined('SMTP_SECURE') && SMTP_SECURE === 'tls') {
                        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    }
                    $mail->Username = SMTP_USER;
                    $mail->Password = SMTP_PASS;
                } else {
                    if (!$mailAvailable) {
                        $this->lastError = 'Funcția mail() nu este disponibilă în acest PHP. Configurează SMTP în config/mail.local.php (SMTP_PASS) sau instalează PHPMailer + SMTP.';
                        return false;
                    }
                    $mail->isMail();
                }

                $mail->CharSet = 'UTF-8';
                $mail->setFrom($this->from, $this->fromName);
                $mail->addAddress($toEmail, $toName ?: $toEmail);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $html;
                if ($text) { $mail->AltBody = $text; }

                $sent = $mail->send();
                if ($sent) { return true; }
                $this->lastError = method_exists($mail, 'ErrorInfo') ? (string)$mail->ErrorInfo : 'PHPMailer send() returned false';
                // If send() reported false, fall through to basic mail()
            } catch (Throwable $e) {
                $this->lastError = $e->getMessage();
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
        // If SMTP creds exist but PHPMailer isn't present, use native SMTP
        $hasSmtpCreds = (defined('SMTP_PASS') && trim((string)SMTP_PASS) !== '');
        if ($hasSmtpCreds && !class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            $smtpHeaders = [
                'Date' => gmdate('D, d M Y H:i:s').' +0000',
                'From' => $this->fromName . ' <' . $this->from . '>',
                'To' => ($toName? $toName.' ' : '') . '<'.$toEmail.'>',
                'Subject' => $encodedSubject,
                'MIME-Version' => '1.0',
                'Reply-To' => $this->from,
                'Content-Type' => 'multipart/alternative; boundary='.$boundary,
            ];
            $bodyData = [
                'From' => $smtpHeaders['From'],
                'To' => $smtpHeaders['To'],
                'Subject' => $encodedSubject,
                'MIME-Version' => '1.0',
                'Reply-To' => $smtpHeaders['Reply-To'],
                'Content-Type' => $smtpHeaders['Content-Type'],
                'Body' => $message,
            ];
            $ok = $this->smtpSendRaw($toEmail, $bodyData);
            if (!$ok) { if (!$this->lastError) $this->lastError = 'Trimitere SMTP nativă eșuată.'; }
            return $ok;
        }
        if (!$mailAvailable) {
            $this->lastError = 'Funcția mail() nu este disponibilă în acest PHP. Configurează SMTP în config/mail.local.php (SMTP_PASS) sau instalează PHPMailer.';
            return false;
        }
        $ok = @mail($toEmail, $encodedSubject, $message, implode("\r\n", $headers));
        if (!$ok && (!defined('SMTP_PASS') || trim((string)SMTP_PASS) === '')) {
            $this->lastError = 'mail() a eșuat. Configurează SMTP în config/mail.local.php (SMTP_PASS).';
        } elseif (!$ok) {
            $this->lastError = 'mail() a returnat false.';
        }
        return $ok;
    }
}
?>