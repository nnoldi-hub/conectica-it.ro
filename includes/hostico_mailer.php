<?php
// Native SMTP mailer for Hostico (PHPMailer blocked)
// Uses pure PHP sockets for SMTP communication

class HosticoMailer {
    private $lastError = '';
    private $debug = false;
    private $smtpLog = [];
    
    public function __construct() {
        // Load config if not already loaded
        $cfgDir = defined('CONFIG_PATH') ? CONFIG_PATH : realpath(__DIR__ . '/../config');
        if ($cfgDir && is_dir($cfgDir)) {
            if (file_exists($cfgDir . '/mail.local.php')) { require_once $cfgDir . '/mail.local.php'; }
            if (file_exists($cfgDir . '/mail.php')) { require_once $cfgDir . '/mail.php'; }
        }
    }
    
    public function getLastError() { 
        return $this->lastError; 
    }
    
    public function setDebug($on = true) { 
        $this->debug = (bool)$on; 
    }
    
    public function getDebugLog() { 
        return $this->smtpLog; 
    }
    
    private function log($message) {
        if ($this->debug) {
            $this->smtpLog[] = $message;
        }
    }
    
    /**
     * Send HTML email using native SMTP
     */
    public function send($toEmail, $toName, $subject, $html, $text = '') {
        $this->lastError = '';
        $this->smtpLog = [];
        
        // Validate configuration
        if (!defined('SMTP_HOST') || !defined('SMTP_USER') || !defined('SMTP_PASS')) {
            $this->lastError = 'Configurație SMTP incompletă în config/mail.local.php';
            return false;
        }
        
        if (!defined('MAIL_FROM') || !defined('MAIL_FROM_NAME')) {
            $this->lastError = 'Configurație expeditor incompletă în config/mail.local.php';
            return false;
        }
        
        if (trim(SMTP_PASS) === '') {
            $this->lastError = 'SMTP_PASS nu este configurat în config/mail.local.php';
            return false;
        }
        
        try {
            return $this->smtpSend($toEmail, $toName, $subject, $html, $text);
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } catch (Throwable $e) {
            $this->lastError = 'Eroare neașteptată: ' . $e->getMessage();
            return false;
        }
    }
    
    private function smtpSend($toEmail, $toName, $subject, $html, $text) {
        $host = SMTP_HOST;
        $port = defined('SMTP_PORT') ? SMTP_PORT : 465;
        $secure = defined('SMTP_SECURE') ? SMTP_SECURE : 'ssl';
        $user = SMTP_USER;
        $pass = SMTP_PASS;
        $from = MAIL_FROM;
        $fromName = MAIL_FROM_NAME;
        
        $this->log("Conectare la $host:$port ($secure)");
        
        // Create socket connection
        $errno = 0; $errstr = '';
        if ($secure === 'ssl') {
            $remote = "ssl://$host:$port";
        } else {
            $remote = "$host:$port";
        }
        
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $smtp = @stream_socket_client($remote, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
        if (!$smtp) {
            $this->lastError = "Conexiune SMTP eșuată: $errstr ($errno)";
            return false;
        }
        
        stream_set_timeout($smtp, 30);
        
        // SMTP conversation helper functions
        $readResponse = function() use ($smtp) {
            $response = '';
            while (!feof($smtp)) {
                $line = fgets($smtp, 1024);
                if ($line === false) break;
                $response .= $line;
                if (preg_match('/^\d{3} /', $line)) break;
            }
            return trim($response);
        };
        
        $sendCommand = function($command) use ($smtp) {
            fwrite($smtp, $command . "\r\n");
        };
        
        $expectCode = function($expectedCode, $command = '') use ($readResponse) {
            $response = $readResponse();
            $code = (int)substr($response, 0, 3);
            if ($code !== $expectedCode) {
                throw new Exception("SMTP Error: Expected $expectedCode, got $code. Response: $response" . ($command ? " (Command: $command)" : ""));
            }
            return $response;
        };
        
        try {
            // Read greeting
            $greeting = $readResponse();
            $this->log("S: $greeting");
            if (!preg_match('/^220/', $greeting)) {
                throw new Exception("SMTP greeting failed: $greeting");
            }
            
            // EHLO
            $sendCommand("EHLO conectica-it.ro");
            $this->log("C: EHLO conectica-it.ro");
            $response = $expectCode(250, 'EHLO');
            $this->log("S: $response");
            
            // STARTTLS if needed
            if ($secure === 'tls') {
                $sendCommand("STARTTLS");
                $this->log("C: STARTTLS");
                $response = $expectCode(220, 'STARTTLS');
                $this->log("S: $response");
                
                if (!stream_socket_enable_crypto($smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new Exception("STARTTLS failed");
                }
                
                // EHLO again after STARTTLS
                $sendCommand("EHLO conectica-it.ro");
                $this->log("C: EHLO conectica-it.ro (post-TLS)");
                $response = $expectCode(250, 'EHLO post-TLS');
                $this->log("S: $response");
            }
            
            // AUTH LOGIN
            $sendCommand("AUTH LOGIN");
            $this->log("C: AUTH LOGIN");
            $response = $expectCode(334, 'AUTH LOGIN');
            $this->log("S: $response");
            
            // Send username
            $sendCommand(base64_encode($user));
            $this->log("C: " . base64_encode($user) . " (username)");
            $response = $expectCode(334, 'AUTH username');
            $this->log("S: $response");
            
            // Send password
            $sendCommand(base64_encode($pass));
            $this->log("C: [password hidden]");
            $response = $expectCode(235, 'AUTH password');
            $this->log("S: $response");
            
            // MAIL FROM
            $sendCommand("MAIL FROM:<$from>");
            $this->log("C: MAIL FROM:<$from>");
            $response = $expectCode(250, 'MAIL FROM');
            $this->log("S: $response");
            
            // RCPT TO
            $sendCommand("RCPT TO:<$toEmail>");
            $this->log("C: RCPT TO:<$toEmail>");
            $response = $expectCode(250, 'RCPT TO');
            $this->log("S: $response");
            
            // DATA
            $sendCommand("DATA");
            $this->log("C: DATA");
            $response = $expectCode(354, 'DATA');
            $this->log("S: $response");
            
            // Build email message
            $boundary = 'boundary_' . uniqid();
            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $encodedFromName = '=?UTF-8?B?' . base64_encode($fromName) . '?=';
            
            $headers = [
                "Date: " . gmdate('D, d M Y H:i:s') . ' +0000',
                "From: $encodedFromName <$from>",
                "To: <$toEmail>",
                "Subject: $encodedSubject",
                "MIME-Version: 1.0",
                "Content-Type: multipart/alternative; boundary=\"$boundary\"",
                "Message-ID: <" . uniqid('msg') . "@conectica-it.ro>",
                ""
            ];
            
            // Generate plain text if not provided
            if (!$text) {
                $text = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html));
            }
            
            $body = [
                "This is a multi-part message in MIME format.",
                "",
                "--$boundary",
                "Content-Type: text/plain; charset=UTF-8",
                "Content-Transfer-Encoding: base64",
                "",
                chunk_split(base64_encode($text), 76, "\r\n"),
                "--$boundary",
                "Content-Type: text/html; charset=UTF-8", 
                "Content-Transfer-Encoding: base64",
                "",
                chunk_split(base64_encode($html), 76, "\r\n"),
                "--$boundary--",
                ""
            ];
            
            $message = implode("\r\n", array_merge($headers, $body));
            
            // Send message data with dot stuffing
            $lines = explode("\r\n", $message);
            foreach ($lines as $line) {
                if ($line === '.') {
                    $line = '..';
                } elseif (strpos($line, '.') === 0) {
                    $line = '.' . $line;
                }
                fwrite($smtp, $line . "\r\n");
            }
            
            // End data with single dot
            $sendCommand(".");
            $this->log("C: . (end data)");
            $response = $expectCode(250, 'DATA end');
            $this->log("S: $response");
            
            // QUIT
            $sendCommand("QUIT");
            $this->log("C: QUIT");
            
            fclose($smtp);
            $this->log("Conexiune închisă cu succes");
            
            return true;
            
        } catch (Exception $e) {
            if (is_resource($smtp)) {
                fclose($smtp);
            }
            $this->lastError = $e->getMessage();
            $this->log("ERROR: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Test SMTP connection
     */
    public function testConnection() {
        $this->setDebug(true);
        
        if (!defined('SMTP_HOST') || !defined('SMTP_USER') || !defined('SMTP_PASS')) {
            return [
                'success' => false,
                'message' => 'Configurație SMTP incompletă',
                'details' => $this->smtpLog
            ];
        }
        
        if (trim(SMTP_PASS) === '') {
            return [
                'success' => false,
                'message' => 'SMTP_PASS nu este configurat',
                'details' => $this->smtpLog
            ];
        }
        
        $host = SMTP_HOST;
        $port = defined('SMTP_PORT') ? SMTP_PORT : 465;
        $secure = defined('SMTP_SECURE') ? SMTP_SECURE : 'ssl';
        
        try {
            // Test basic connection
            $errno = 0; $errstr = '';
            if ($secure === 'ssl') {
                $remote = "ssl://$host:$port";
            } else {
                $remote = "$host:$port";
            }
            
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);
            
            $smtp = @stream_socket_client($remote, $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);
            if (!$smtp) {
                return [
                    'success' => false,
                    'message' => "Conexiune SMTP eșuată: $errstr ($errno)",
                    'details' => $this->smtpLog
                ];
            }
            
            $greeting = fgets($smtp, 1024);
            $this->log("Connection test - Greeting: " . trim($greeting));
            fclose($smtp);
            
            if (!preg_match('/^220/', $greeting)) {
                return [
                    'success' => false,
                    'message' => "Server SMTP nu răspunde corect: " . trim($greeting),
                    'details' => $this->smtpLog
                ];
            }
            
            return [
                'success' => true,
                'message' => "Conexiune SMTP reușită la $host:$port",
                'details' => $this->smtpLog
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'details' => $this->smtpLog
            ];
        }
    }
}
?>
