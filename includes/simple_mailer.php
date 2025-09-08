<?php
// Simple, clean PHPMailer wrapper for newsletters
// Uses only PHPMailer (already installed via Composer)

// Load Composer autoloader if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class NewsletterMailer {
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
    
    /**
     * Send HTML email using PHPMailer
     * @param string $toEmail Recipient email
     * @param string $toName Recipient name (optional)
     * @param string $subject Email subject
     * @param string $html HTML content
     * @param string $text Plain text alternative (optional)
     * @return bool True on success
     */
    public function send($toEmail, $toName, $subject, $html, $text = '') {
        $this->lastError = '';
        $this->smtpLog = [];
        
        // Check if PHPMailer is available
        if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            $this->lastError = 'PHPMailer nu este disponibil. Rulează: composer install';
            return false;
        }
        
        // Validate required constants
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
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->Port = defined('SMTP_PORT') ? SMTP_PORT : 587;
            
            // Encryption
            if (defined('SMTP_SECURE')) {
                if (SMTP_SECURE === 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } elseif (SMTP_SECURE === 'tls') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
            }
            
            // Debug mode
            if ($this->debug) {
                $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
                $mail->Debugoutput = function($str, $level) {
                    $this->smtpLog[] = trim($str);
                };
            }
            
            // Character set and encoding
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64'; // Safe encoding for all content
            
            // Recipients
            $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $mail->addAddress($toEmail, $toName ?: '');
            $mail->addReplyTo(MAIL_FROM, MAIL_FROM_NAME);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            
            // Plain text alternative
            if ($text) {
                $mail->AltBody = $text;
            } else {
                // Generate simple text from HTML
                $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html));
            }
            
            // Send
            $result = $mail->send();
            
            if ($result) {
                return true;
            } else {
                $this->lastError = 'PHPMailer send() returned false';
                return false;
            }
            
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } catch (Throwable $e) {
            $this->lastError = 'Eroare neașteptată: ' . $e->getMessage();
            return false;
        }
    }
    
    /**
     * Test SMTP connection
     * @return array ['success' => bool, 'message' => string, 'details' => array]
     */
    public function testConnection() {
        $this->setDebug(true);
        
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->Port = defined('SMTP_PORT') ? SMTP_PORT : 587;
            
            if (defined('SMTP_SECURE')) {
                if (SMTP_SECURE === 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } elseif (SMTP_SECURE === 'tls') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
            }
            
            $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            $mail->Debugoutput = function($str, $level) {
                $this->smtpLog[] = trim($str);
            };
            
            // Test connection without sending
            $connected = $mail->smtpConnect();
            $mail->smtpClose();
            
            return [
                'success' => $connected,
                'message' => $connected ? 'Conexiune SMTP reușită' : 'Conexiune SMTP eșuată',
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
