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
            $this->mail->Body = "
<!DOCTYPE html>
<html lang='nl'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body style='margin:0; padding:0; background-color:#F9F5ED; font-family: DM Sans, Arial, sans-serif;'>

  <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#F9F5ED; padding: 40px 20px;'>
    <tr>
      <td align='center'>
        <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px; width:100%; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 4px 24px rgba(58,43,32,0.08);'>

          <!-- HEADER -->
          <tr>
            <td style='background: linear-gradient(135deg, #3A2B20 0%, #7E6A52 100%); padding: 36px 40px; text-align:center;'>
              <h1 style='margin:0; font-family: Georgia, serif; font-size: 26px; font-weight: 700; color: #ffffff; letter-spacing: -0.3px;'>CleanStone</h1>
              <p style='margin: 8px 0 0; font-size: 13px; color: rgba(255,255,255,0.7);'>Specialist in natuursteen onderhoud</p>
            </td>
          </tr>

          <!-- BODY -->
          <tr>
            <td style='padding: 40px 40px 32px;'>

              <!-- Bevestiging icon -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td align='center' style='padding-bottom: 28px;'>
                    <img src='http://localhost:67/public/assets/logo-cleanstone.png' width='60' height='60' alt='CleanStone' style='border-radius: 50%; display: block;'>
                  </td>
                </tr>
              </table>

              <h2 style='margin: 0 0 8px; font-family: Georgia, serif; font-size: 22px; font-weight: 700; color: #3A2B20; text-align: center;'>Adviesaanvraag ontvangen</h2>
              <p style='margin: 0 0 28px; font-size: 14px; color: #7E6A52; text-align: center;'>Wij hebben uw aanvraag in goede orde ontvangen</p>

              <p style='margin: 0 0 20px; font-size: 15px; color: #3A2B20; line-height: 1.6;'>Beste {$toName},</p>
              <p style='margin: 0 0 28px; font-size: 15px; color: #7E6A52; line-height: 1.7;'>Wij hebben uw adviesaanvraag in goede orde ontvangen. Onze specialisten bekijken uw aanvraag zo snel mogelijk en komen persoonlijk bij u terug.</p>

              <!-- Info box -->
              <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #F9F5ED; border-radius: 12px; margin-bottom: 28px;'>
                <tr>
                  <td style='padding: 24px 28px;'>
                    <p style='margin: 0 0 16px; font-size: 13px; font-weight: 700; color: #3A2B20; text-transform: uppercase; letter-spacing: 0.06em;'>Wat kunt u verwachten?</p>

                    <!-- item 1 -->
                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 12px;'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>1</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'><strong>Gemiddelde reactietijd:</strong> 4 uur op werkdagen</p>
                        </td>
                      </tr>
                    </table>

                    <!-- item 2 -->
                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 12px;'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>2</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'>U ontvangt een <strong>persoonlijk advies op maat</strong></p>
                        </td>
                      </tr>
                    </table>

                    <!-- item 3 -->
                    <table width='100%' cellpadding='0' cellspacing='0'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>3</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'>Volg de chat via <strong>uw account</strong></p>
                        </td>
                      </tr>
                    </table>

                  </td>
                </tr>
              </table>

              <!-- CTA knop -->
              <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 32px;'>
                <tr>
                  <td align='center'>
                    <a href='https://cleanstone.nl/account/adviesaanvraag' style='display: inline-block; background-color: #3A2B20; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; padding: 14px 32px; border-radius: 8px; letter-spacing: 0.02em;'>Bekijk mijn aanvraag</a>
                  </td>
                </tr>
              </table>

              <p style='margin: 0; font-size: 15px; color: #3A2B20; line-height: 1.7;'>Met vriendelijke groet,<br><strong>Team CleanStone</strong></p>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style='background-color: #F9F5ED; padding: 24px 40px; border-top: 1px solid #DACFB6; text-align: center;'>
              <p style='margin: 0 0 6px; font-size: 12px; color: #B89C82;'>CleanStone · Specialist in natuursteen onderhoud</p>
              <p style='margin: 0; font-size: 11px; color: #B89C82;'>U ontvangt deze e-mail omdat u een adviesaanvraag heeft ingediend.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
";

            $this->mail->AltBody = "Beste {$toName}, uw adviesaanvraag is ontvangen. Wij nemen binnen 4 uur contact met u op. Bekijk uw aanvraag op: https://cleanstone.nl/account/adviesaanvraag";

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