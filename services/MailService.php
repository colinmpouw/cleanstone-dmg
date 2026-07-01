<?php

namespace services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use repositories\OrderRepository;

class   MailService
{
    private PHPMailer $mail;
    private OrderRepository $orderRepository;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = '127.0.0.1';
        $this->mail->Port       = 1025;
        $this->mail->SMTPAuth   = false;
        $this->mail->SMTPSecure = '';
        $this->mail->SMTPAutoTLS = false;
        $this->mail->CharSet    = 'UTF-8';
        $this->mail->isHTML(true);
        $this->mail->setFrom('info@cleanstone.nl', 'CleanStone');

        $this->orderRepository = new OrderRepository();
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

    public function sendResetCode(string $toEmail, string $toName, string $code): void
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->Subject = 'Uw verificatiecode — CleanStone';
            $this->mail->Body    = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #3A2B20;'>Wachtwoord vergeten</h2>
                <p>Beste {$toName},</p>
                <p>Uw verificatiecode is:</p>
                <div style='font-size: 36px; font-weight: bold; letter-spacing: 8px;
                            color: #3A2B20; padding: 20px; background: #F9F5ED;
                            border-radius: 10px; text-align: center; margin: 20px 0;'>
                    {$code}
                </div>
                <p>Deze code is 15 minuten geldig.</p>
                <p>Als u dit niet heeft aangevraagd, kunt u deze e-mail negeren.</p>
                <p style='margin-top: 24px;'>Met vriendelijke groet,<br><strong>Team CleanStone</strong></p>
            </div>
        ";
            $this->mail->AltBody = "Uw verificatiecode: {$code}. Geldig voor 15 minuten.";

            $this->mail->send();
        } catch (Exception $e) {
            $this->writeLog($toEmail, $e);
        }
    }

    public function sendWelkomMail(string $toEmail, string $toName): void
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->Subject = 'Welkom bij CleanStone!';
            $this->mail->Body    = "
<!DOCTYPE html>
<html lang='nl'>
<head><meta charset='UTF-8'></head>
<body style='margin:0; padding:0; background-color:#F9F5ED; font-family: Arial, sans-serif;'>

  <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#F9F5ED; padding: 40px 20px;'>
    <tr>
      <td align='center'>
        <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px; width:100%; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 4px 24px rgba(58,43,32,0.08);'>

          <!-- HEADER -->
          <tr>
            <td style='background: linear-gradient(135deg, #3A2B20 0%, #7E6A52 100%); padding: 36px 40px; text-align:center;'>
              <h1 style='margin:0; font-family: Georgia, serif; font-size: 26px; font-weight: 700; color: #ffffff;'>CleanStone</h1>
              <p style='margin: 8px 0 0; font-size: 13px; color: rgba(255,255,255,0.7);'>Specialist in natuursteen onderhoud</p>
            </td>
          </tr>

          <!-- BODY -->
          <tr>
            <td style='padding: 40px 40px 32px;'>

              <h2 style='margin: 0 0 8px; font-family: Georgia, serif; font-size: 22px; font-weight: 700; color: #3A2B20; text-align: center;'>Welkom bij CleanStone!</h2>
              <p style='margin: 0 0 28px; font-size: 14px; color: #7E6A52; text-align: center;'>Uw account is succesvol aangemaakt</p>

              <p style='margin: 0 0 16px; font-size: 15px; color: #3A2B20; line-height: 1.6;'>Beste {$toName},</p>
              <p style='margin: 0 0 28px; font-size: 15px; color: #7E6A52; line-height: 1.7;'>Welkom bij CleanStone! Uw account is succesvol aangemaakt. U kunt nu inloggen en gebruik maken van al onze diensten.</p>

              <!-- Info box -->
              <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #F9F5ED; border-radius: 12px; margin-bottom: 28px;'>
                <tr>
                  <td style='padding: 24px 28px;'>
                    <p style='margin: 0 0 16px; font-size: 13px; font-weight: 700; color: #3A2B20; text-transform: uppercase; letter-spacing: 0.06em;'>Wat kunt u doen?</p>

                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 12px;'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>1</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'>Bekijk onze <strong>premium producten</strong> en bundels</p>
                        </td>
                      </tr>
                    </table>

                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 12px;'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>2</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'>Vraag <strong>gratis expert advies</strong> aan voor uw natuursteen</p>
                        </td>
                      </tr>
                    </table>

                    <table width='100%' cellpadding='0' cellspacing='0'>
                      <tr>
                        <td width='28' valign='top'>
                          <div style='width: 20px; height: 20px; border-radius: 50%; background-color: #3A2B20; text-align: center; line-height: 20px; font-size: 11px; color: #ffffff; font-weight: 700;'>3</div>
                        </td>
                        <td style='padding-left: 10px;'>
                          <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.5;'>Beheer uw <strong>bestellingen en account</strong></p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- CTA -->
              <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 32px;'>
                <tr>
                  <td align='center'>
                    <a href='http://localhost:67/producten' style='display: inline-block; background-color: #3A2B20; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; padding: 14px 32px; border-radius: 8px;'>Bekijk onze producten</a>
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
              <p style='margin: 0; font-size: 11px; color: #B89C82;'>U ontvangt deze e-mail omdat u zich heeft geregistreerd.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>";

            $this->mail->AltBody = "Welkom bij CleanStone, {$toName}! Uw account is succesvol aangemaakt. Bezoek ons op cleanstone.nl";

            $this->mail->send();
        } catch (Exception $e) {
            $this->writeLog($toEmail, $e);
        }
    }

    public function sendBestellingMail(int $orderId): void
    {
        try {
            $order = $this->orderRepository->getOrderForMail($orderId);

            if (!$order) {
                return;
            }

            $this->mail->clearAddresses();
            $this->mail->addAddress(
                $order['email'],
                $order['first_name'] . ' ' . $order['last_name']
            );

            $subtotal = 0;
            $productenHtml = '';

            foreach ($order['products'] as $product) {
                $line      = $product['price'] * $product['quantity'];
                $subtotal += $line;

                $productenHtml .= "
                  <tr>
                    <td style='padding: 14px 16px; border-bottom: 1px solid #EDE8DF; font-size: 14px; color: #3A2B20;'>" . htmlspecialchars($product['name']) . "</td>
                    <td style='padding: 14px 16px; border-bottom: 1px solid #EDE8DF; font-size: 14px; color: #7E6A52; text-align: center;'>" . (int)$product['quantity'] . "</td>
                    <td style='padding: 14px 16px; border-bottom: 1px solid #EDE8DF; font-size: 14px; color: #3A2B20; text-align: right; white-space: nowrap;'>&euro;&nbsp;" . number_format($line, 2, ',', '.') . "</td>
                  </tr>";
            }

            $deliveryPrice   = (float)($order['delivery_price'] ?? 0);
            $discountAmount  = (float)($order['discount_amount'] ?? 0);
            $totalPrice      = (float)$order['total_price'];
            $deliveryLabel   = $deliveryPrice > 0
                ? '&euro;&nbsp;' . number_format($deliveryPrice, 2, ',', '.')
                : '<span style="color:#4CAF50; font-weight:600;">Gratis</span>';

            $discountRow = '';
            if ($discountAmount > 0) {
                $discountRow = "
                  <tr>
                    <td colspan='2' style='padding: 10px 16px; font-size: 14px; color: #7E6A52;'>Korting</td>
                    <td style='padding: 10px 16px; font-size: 14px; color: #4CAF50; text-align: right; white-space: nowrap;'>- &euro;&nbsp;" . number_format($discountAmount, 2, ',', '.') . "</td>
                  </tr>";
            }

            $orderDate = date('d-m-Y', strtotime($order['created_at']));

            $this->mail->Subject = "Bevestiging bestelling #" . $order['id'] . " \xe2\x80\x94 CleanStone";

            $this->mail->Body = "<!DOCTYPE html>
<html lang='nl'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body style='margin:0; padding:0; background-color:#F2EDE4; font-family: Arial, Helvetica, sans-serif;'>

  <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#F2EDE4; padding: 48px 16px;'>
    <tr>
      <td align='center'>
        <table width='600' cellpadding='0' cellspacing='0' style='max-width:600px; width:100%;'>

          <!-- LOGO BALK -->
          <tr>
            <td align='center' style='padding-bottom: 28px;'>
              <p style='margin:0; font-family: Georgia, serif; font-size: 22px; font-weight: 700; color: #3A2B20; letter-spacing: 2px; text-transform: uppercase;'>CleanStone</p>
              <p style='margin: 4px 0 0; font-size: 12px; color: #9C8672; letter-spacing: 1px; text-transform: uppercase;'>Specialist in natuursteen onderhoud</p>
            </td>
          </tr>

          <!-- MAIN CARD -->
          <tr>
            <td style='background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 20px rgba(58,43,32,0.10);'>

              <!-- HEADER -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='background: linear-gradient(135deg, #3A2B20 0%, #6B5440 100%); padding: 40px 40px 36px; text-align: center;'>
                    <p style='margin: 0 0 10px; font-size: 40px; line-height: 1;'>&#10003;</p>
                    <h1 style='margin: 0 0 8px; font-family: Georgia, serif; font-size: 24px; font-weight: 700; color: #ffffff; letter-spacing: -0.3px;'>Bestelling bevestigd!</h1>
                    <p style='margin: 0; font-size: 14px; color: rgba(255,255,255,0.70);'>Bedankt voor uw aankoop bij CleanStone</p>
                  </td>
                </tr>
              </table>

              <!-- BODY -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding: 36px 40px 0;'>

                    <p style='margin: 0 0 6px; font-size: 15px; color: #3A2B20; line-height: 1.6;'>Beste <strong>" . htmlspecialchars($order['first_name']) . "</strong>,</p>
                    <p style='margin: 0 0 28px; font-size: 14px; color: #7E6A52; line-height: 1.7;'>Wij hebben uw bestelling in goede orde ontvangen en gaan deze zo snel mogelijk verwerken. Hieronder vindt u een overzicht van uw bestelling.</p>

                    <!-- ORDER META -->
                    <table width='100%' cellpadding='0' cellspacing='0' style='background: #F9F5EE; border-radius: 10px; margin-bottom: 28px;'>
                      <tr>
                        <td style='padding: 20px 24px;'>
                          <table width='100%' cellpadding='0' cellspacing='0'>
                            <tr>
                              <td style='padding: 6px 0; font-size: 13px; color: #9C8672; width: 50%;'>Bestelnummer</td>
                              <td style='padding: 6px 0; font-size: 13px; color: #3A2B20; font-weight: 700; text-align: right;'>#" . $order['id'] . "</td>
                            </tr>
                            <tr>
                              <td style='padding: 6px 0; font-size: 13px; color: #9C8672;'>Besteldatum</td>
                              <td style='padding: 6px 0; font-size: 13px; color: #3A2B20; text-align: right;'>" . $orderDate . "</td>
                            </tr>
                            <tr>
                              <td style='padding: 6px 0; font-size: 13px; color: #9C8672;'>Betaalmethode</td>
                              <td style='padding: 6px 0; font-size: 13px; color: #3A2B20; text-align: right; text-transform: capitalize;'>" . htmlspecialchars($order['payment_method']) . "</td>
                            </tr>
                            <tr>
                              <td style='padding: 6px 0; font-size: 13px; color: #9C8672;'>Verzendmethode</td>
                              <td style='padding: 6px 0; font-size: 13px; color: #3A2B20; text-align: right; text-transform: capitalize;'>" . htmlspecialchars($order['delivery_option']) . "</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <!-- PRODUCTS HEADER -->
                    <p style='margin: 0 0 10px; font-size: 13px; font-weight: 700; color: #3A2B20; text-transform: uppercase; letter-spacing: 0.07em;'>Uw bestelling</p>

                  </td>
                </tr>
              </table>

              <!-- PRODUCT TABLE -->
              <table width='100%' cellpadding='0' cellspacing='0' style='border-collapse: collapse;'>
                <tr style='background: #3A2B20;'>
                  <th style='padding: 12px 16px; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.85); text-align: left; letter-spacing: 0.05em; text-transform: uppercase;'>Product</th>
                  <th style='padding: 12px 16px; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.85); text-align: center; letter-spacing: 0.05em; text-transform: uppercase; width: 60px;'>Qty</th>
                  <th style='padding: 12px 16px; font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.85); text-align: right; letter-spacing: 0.05em; text-transform: uppercase;'>Prijs</th>
                </tr>
                " . $productenHtml . "
              </table>

              <!-- PRICE SUMMARY -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding: 0 40px 32px;'>
                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-top: 4px;'>
                      <tr>
                        <td colspan='2' style='padding: 10px 16px; font-size: 14px; color: #7E6A52;'>Subtotaal</td>
                        <td style='padding: 10px 16px; font-size: 14px; color: #3A2B20; text-align: right; white-space: nowrap;'>&euro;&nbsp;" . number_format($subtotal, 2, ',', '.') . "</td>
                      </tr>
                      <tr>
                        <td colspan='2' style='padding: 10px 16px; font-size: 14px; color: #7E6A52;'>Verzendkosten</td>
                        <td style='padding: 10px 16px; font-size: 14px; color: #3A2B20; text-align: right; white-space: nowrap;'>" . $deliveryLabel . "</td>
                      </tr>
                      " . $discountRow . "
                      <tr>
                        <td colspan='3' style='padding: 0; border-top: 2px solid #EDE8DF;'></td>
                      </tr>
                      <tr>
                        <td colspan='2' style='padding: 14px 16px; font-size: 16px; font-weight: 700; color: #3A2B20;'>Totaal</td>
                        <td style='padding: 14px 16px; font-size: 16px; font-weight: 700; color: #3A2B20; text-align: right; white-space: nowrap;'>&euro;&nbsp;" . number_format($totalPrice, 2, ',', '.') . "</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- SHIPPING ADDRESS -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding: 0 40px 36px;'>
                    <table width='100%' cellpadding='0' cellspacing='0' style='background: #F9F5EE; border-radius: 10px;'>
                      <tr>
                        <td style='padding: 20px 24px;'>
                          <p style='margin: 0 0 10px; font-size: 12px; font-weight: 700; color: #3A2B20; text-transform: uppercase; letter-spacing: 0.07em;'>Verzendadres</p>
                          <p style='margin: 0; font-size: 14px; color: #7E6A52; line-height: 1.7;'>
                            " . htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) . "<br>
                            " . htmlspecialchars($order['street'] . ' ' . $order['house_number']) . "<br>
                            " . htmlspecialchars($order['postal_code'] . ' ' . $order['city']) . "<br>
                            " . htmlspecialchars($order['country']) . "
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- CLOSING TEXT -->
              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding: 0 40px 40px;'>
                    <p style='margin: 0 0 20px; font-size: 14px; color: #7E6A52; line-height: 1.7;'>Zodra uw bestelling is verzonden ontvangt u een e-mail met de trackinginformatie.</p>
                    <p style='margin: 0; font-size: 14px; color: #3A2B20; line-height: 1.7;'>Met vriendelijke groet,<br><strong>Team CleanStone</strong></p>
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td align='center' style='padding-top: 28px; padding-bottom: 12px;'>
              <p style='margin: 0 0 4px; font-size: 12px; color: #B89C82;'>CleanStone &middot; Specialist in natuursteen onderhoud</p>
              <p style='margin: 0; font-size: 11px; color: #C4B09A;'>U ontvangt deze e-mail omdat u een bestelling heeft geplaatst.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>";

            $this->mail->AltBody = "Beste {$order['first_name']}, bedankt voor uw bestelling #" . $order['id'] . " bij CleanStone. Totaal: EUR " . number_format($totalPrice, 2, ',', '.');

            $this->mail->send();

        } catch (Exception $e) {
            $this->writeLog($order['email'] ?? '', $e);
        }
    }



    public function sendOrderStatusMail(int $order_id, string $status): void
{
    try {
        // haal order + user op
        $DB    = new \controllers\DatabaseController();
        $order = $DB->read(
            "SELECT o.*, u.email, u.username FROM orders o
             JOIN users u ON u.id = o.user_id
             WHERE o.id = :id",
            ['id' => $order_id]
        );

        if (empty($order)) return;
        $order = $order[0];

        $statusLabels = [
            'pending'    => 'In afwachting',
            'paid'       => 'Betaald',
            'processing' => 'In verwerking',
            'shipped'    => 'Verzonden',
            'completed'  => 'Geleverd',
            'cancelled'  => 'Geannuleerd',
        ];

        $statusLabel = $statusLabels[$status] ?? ucfirst($status);
        $toEmail     = $order['email'];
        $toName      = $order['username'];

        $this->mail->clearAddresses();
        $this->mail->addAddress($toEmail, $toName);

        $this->mail->Subject = "Uw bestelling #{$order_id} — {$statusLabel}";
        $this->mail->Body    = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #3A2B20;'>Statusupdate bestelling #{$order_id}</h2>
                <p>Beste {$toName},</p>
                <p>De status van uw bestelling is bijgewerkt naar: <strong>{$statusLabel}</strong>.</p>
                <p style='margin-top: 24px;'>Met vriendelijke groet,<br><strong>Team CleanStone</strong></p>
            </div>
        ";
        $this->mail->AltBody = "Beste {$toName}, uw bestelling #{$order_id} heeft nu de status: {$statusLabel}.";

        $this->mail->send();
    } catch (Exception $e) {
        $this->writeLog('order-status', $e);
    }
}

    private function writeLog(string $toEmail, Exception $e): void
    {
        $logFile = __DIR__ . '/../../logs/mail.log';
        if (!is_dir(dirname($logFile))) mkdir(dirname($logFile), 0755, true);
        $timestamp = date('Y-m-d H:i:s');
        $log  = "[{$timestamp}] Verzenden mislukt naar: {$toEmail}\n";
        $log .= "[{$timestamp}] PHPMailer fout: {$this->mail->ErrorInfo}\n";
        $log .= "[{$timestamp}] Exception: {$e->getMessage()}\n";
        $log .= str_repeat('-', 60) . "\n";
        file_put_contents($logFile, $log, FILE_APPEND);
    }
}