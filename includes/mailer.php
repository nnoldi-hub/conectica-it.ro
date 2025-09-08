<?php
// Load mail configuration gracefully (optional files) and define defaults
// Prefer CONFIG_PATH from init.php; fallback to local ../config
$__cfgDir = defined('CONFIG_PATH') ? CONFIG_PATH : realpath(__DIR__ . '/../config');
if ($__cfgDir && is_dir($__cfgDir)) {
    // Load local overrides first so they take precedence (defines are immutable)
    if (file_exists($__cfgDir . '/mail.local.php')) { require_once $__cfgDir . '/mail.local.php'; }
    if (file_exists($__cfgDir . '/mail.php')) { require_once $__cfgDir . '/mail.php'; }
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
    private $debug = false; private $smtpLog = [];
    public function __construct() {
        $this->from = defined('MAIL_FROM') ? MAIL_FROM : 'no-reply@localhost';
        $this->fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Conectica-IT';
    }
    public function getLastError() { return $this->lastError; }
    public function setDebug($on = true) { $this->debug = (bool)$on; }
    public function getDebugLog() { return $this->smtpLog; }
    private function smtpSendRaw($toEmail, $data) {
        $host = SMTP_HOST; $port = (int)SMTP_PORT; $secure = strtolower((string)SMTP_SECURE);
        $user = (string)SMTP_USER; $pass = (string)SMTP_PASS;
        $errno = 0; $errstr = '';
        $remote = ($secure === 'ssl' ? "ssl://$host" : $host) . ':' . $port;
        $ctx = stream_context_create([ 'ssl' => [ 'verify_peer' => false, 'verify_peer_name' => false ] ]);
        $fp = @stream_socket_client($remote, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) { $this->lastError = 'Conexiune SMTP eșuată: ' . $errstr; $this->smtpLog[] = 'ERR connect: '.$errstr; return false; }
        stream_set_timeout($fp, 15);
        $read = function() use ($fp) { $line = ''; while (!feof($fp)) { $l = fgets($fp, 2048); if ($l===false) break; $line .= $l; if (preg_match('~^\d{3} (.*)\r?\n$~', $l)) break; if (!preg_match('~^\d{3}-~', $l)) break; } return $line; };
        $write = function($cmd) use ($fp) { fwrite($fp, $cmd."\r\n"); };
        $expect = function($code) use ($read) { $resp = $read(); if (!preg_match('~^'.preg_quote((string)$code,'~').'~', $resp)) { return [false,$resp]; } return [true,$resp]; };
        $resp = $read(); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp);
        $write('EHLO conectica-it.ro'); if ($this->debug) $this->smtpLog[] = 'C: EHLO conectica-it.ro'; list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp);
        if(!$ok && stripos($resp,'502')!==false){ $write('HELO conectica-it.ro'); if ($this->debug) $this->smtpLog[] = 'C: HELO conectica-it.ro'; list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); }
        if(!$ok){ fclose($fp); $this->lastError = 'EHLO/HELO eșuat: '.trim($resp); return false; }
        if ($secure === 'tls') {
            $write('STARTTLS'); if ($this->debug) $this->smtpLog[] = 'C: STARTTLS'; list($ok,$resp) = $expect(220); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'STARTTLS eșuat: '.trim($resp); return false; }
            if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { fclose($fp); $this->lastError = 'Handshake TLS eșuat'; return false; }
            $write('EHLO conectica-it.ro'); if ($this->debug) $this->smtpLog[] = 'C: EHLO conectica-it.ro'; list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'EHLO post-TLS eșuat: '.trim($resp); return false; }
        }
        if ($user !== '' || $pass !== '') {
            $write('AUTH LOGIN'); if ($this->debug) $this->smtpLog[] = 'C: AUTH LOGIN'; list($ok,$resp) = $expect(334); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'AUTH LOGIN resp invalid: '.trim($resp); return false; }
            $write(base64_encode($user)); if ($this->debug) $this->smtpLog[] = 'C: USER <hidden>'; list($ok,$resp) = $expect(334); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'AUTH user resp invalid: '.trim($resp); return false; }
            $write(base64_encode($pass)); if ($this->debug) $this->smtpLog[] = 'C: PASS <hidden>'; list($ok,$resp) = $expect(235); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'AUTH parolă resp invalid: '.trim($resp); return false; }
        }
        $fromAddr = preg_match('/<([^>]+)>/', $data['From']??'', $m) ? $m[1] : $this->from;
        $write('MAIL FROM:<'.$fromAddr.'>'); if ($this->debug) $this->smtpLog[] = 'C: MAIL FROM:<'.$fromAddr.'>'; list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'MAIL FROM eșuat: '.trim($resp); return false; }
        $write('RCPT TO:<'.$toEmail.'>'); if ($this->debug) $this->smtpLog[] = 'C: RCPT TO:<'.$toEmail.'>'; list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'RCPT TO eșuat: '.trim($resp); return false; }
        $write('DATA'); if ($this->debug) $this->smtpLog[] = 'C: DATA'; list($ok,$resp) = $expect(354); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'DATA eșuat: '.trim($resp); return false; }
        // Build DATA payload with line length safety
        $lines = [];
        foreach ($data as $k=>$v) { 
            if ($k==='Body') continue; 
            // Split long header lines at 76 chars with proper folding
            $header = $k.': '.$v;
            if (strlen($header) > 76) {
                $lines[] = substr($header, 0, 76);
                $remaining = substr($header, 76);
                while (strlen($remaining) > 0) {
                    $lines[] = ' ' . substr($remaining, 0, 75); // continuation with space
                    $remaining = substr($remaining, 75);
                }
            } else {
                $lines[] = $header;
            }
        }
        $lines[] = '';
        $body = str_replace(["\r\n","\r"], "\n", $data['Body']);
        $body = preg_replace('~\n\.~', "\n..", $body); // dot-stuffing
        $lines[] = $body;
        $payload = implode("\r\n", $lines) . "\r\n.";
    fwrite($fp, $payload."\r\n");
    list($ok,$resp) = $expect(250); if ($this->debug) $this->smtpLog[] = 'S: '.trim($resp); if(!$ok){ fclose($fp); $this->lastError = 'Trimitere DATA eșuată: '.trim($resp); return false; }
    $write('QUIT'); if ($this->debug) $this->smtpLog[] = 'C: QUIT';
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
        $fromName = $this->fromName;
        if (preg_match('/[^\x20-\x7E]/', $fromName)) { // non-ASCII
            if (function_exists('mb_encode_mimeheader')) { $fromName = mb_encode_mimeheader($fromName, 'UTF-8', 'B', '\r\n'); }
        }
        $headers[] = 'From: ' . $fromName . ' <' . $this->from . '>';
        $headers[] = 'Reply-To: ' . $this->from;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
        $headers[] = 'Date: ' . gmdate('D, d M Y H:i:s') . ' +0000';
        $headers[] = 'Message-ID: <' . uniqid('cid'). '@' . preg_replace('~^.*@~', '', $this->from) . '>';

        $altText = $text ?: strip_tags(str_replace(['<br>','<br/>','<br />'], "\n", $html));
        $encodeQP = function($s){
            // Always use base64 for safety - ensures no lines exceed 76 chars
            $b64 = rtrim(chunk_split(base64_encode((string)$s), 76, "\r\n"));
            return ['encoded' => $b64, 'cte' => 'base64'];
        };
        $plainEnc = $encodeQP($altText);
        $htmlEnc = $encodeQP($html);

        $message = "This is a multi-part message in MIME format.\r\n";
        $message .= "--$boundary\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: {$plainEnc['cte']}\r\n\r\n";
        $message .= $plainEnc['encoded'] . "\r\n";
        $message .= "--$boundary\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: {$htmlEnc['cte']}\r\n\r\n";
        $message .= $htmlEnc['encoded'] . "\r\n";
        $message .= "--$boundary--\r\n";

        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        // If SMTP creds exist but PHPMailer isn't present, use native SMTP
        $hasSmtpCreds = (defined('SMTP_PASS') && trim((string)SMTP_PASS) !== '');
        if ($hasSmtpCreds && !class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            // Generate short Message-ID to avoid long lines
            $msgId = '<' . uniqid('m') . '@conectica-it.ro>';
            $smtpHeaders = [
                'Date' => gmdate('D, d M Y H:i:s').' +0000',
                'From' => $this->from, // Simplified From header
                'To' => '<'.$toEmail.'>',
                'Subject' => $encodedSubject,
                'MIME-Version' => '1.0',
                'Reply-To' => $this->from,
                'Content-Type' => 'multipart/alternative; boundary="'.$boundary.'"',
                'Message-ID' => $msgId,
            ];
            $bodyData = [
                'From' => $smtpHeaders['From'],
                'To' => $smtpHeaders['To'],
                'Subject' => $encodedSubject,
                'MIME-Version' => '1.0',
                'Reply-To' => $smtpHeaders['Reply-To'],
                'Content-Type' => $smtpHeaders['Content-Type'],
                'Date' => $smtpHeaders['Date'],
                'Message-ID' => $smtpHeaders['Message-ID'],
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