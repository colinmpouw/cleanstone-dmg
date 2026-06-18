<?php

namespace services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = '127.0.0.1';
        $this->mail->Port       = 1025;
        $this->mail->SMTPAuth   = false;
        $this->mail->SMTPSecure = '';
        $this->mail->SMTPAutoTLS = false;
        $this->mail->isHTML(true);
        $this->mail->setFrom('info@cleanstone.nl', 'CleanStone');
    }

    public function sendAdviesBevestiging(string $toEmail, string $toName): void
    {
        try {

            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->Subject = 'Uw adviesaanvraag is ontvangen — CleanStone';
            $this->mail->Body    = "
                <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #3A2B20;'>Adviesaanvraag ontvangen</h2>
                    <p>Beste {$toName},</p>
                    <p>Wij hebben uw adviesaanvraag in goede orde ontvangen. Onze specialisten bekijken uw aanvraag zo snel mogelijk.</p>
                    <p><strong>Wat kunt u verwachten?</strong></p>
                    <ul>
                        <li>Gemiddelde reactietijd: 4 uur op werkdagen</li>
                        <li>U ontvangt een persoonlijk advies op maat</li>
                        <li>U kunt de chat volgen via uw account</li>
                    </ul>
                    <p style='margin-top: 24px;'>Met vriendelijke groet,<br><strong>Team CleanStone</strong></p>
                </div>
            ";
            $this->mail->AltBody = "Beste {$toName}, uw adviesaanvraag is ontvangen. Wij nemen binnen 4 uur contact met u op.";

            $this->mail->send();
        } catch (Exception $e) {
            error_log('Mail error: ' . $this->mail->ErrorInfo);
            $logFile = __DIR__ . '/../mail.log';
            $logDir  = dirname($logFile);

            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }

            $timestamp = date('Y-m-d H:i:s');
            $logLine   = "[{$timestamp}] Verzenden mislukt naar: {$toEmail}\n";
            $logLine  .= "[{$timestamp}] PHPMailer fout: {$this->mail->ErrorInfo}\n";
            $logLine  .= "[{$timestamp}] Exception: {$e->getMessage()}\n";
            $logLine  .= str_repeat('-', 60) . "\n";

            file_put_contents($logFile, $logLine, FILE_APPEND);
        }
    }
}