<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/advies.css">
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <title>Cleanstone -Advies</title>
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="page-title">
    <h1>Gratis Expert Advies</h1>
    <p>Upload foto's van uw natuursteen en ontvang binnen 24 uur persoonlijk advies</p>
</div>

<!-- MAIN -->
<section class="advies-page">
    <div class="advies-page__inner">

        <!-- LEFT -->
        <div class="advies-left">
            <h2>Hoe werkt het?</h2>

            <div class="advies-steps">
                <div class="advies-step">
                    <div class="advies-step__num">1</div>
                    <div class="advies-step__text">
                        <strong>Upload foto's</strong>
                        <p>Maak duidelijke foto's van uw natuursteen en eventuele vlekken of problemen</p>
                    </div>
                </div>
                <div class="advies-step">
                    <div class="advies-step__num">2</div>
                    <div class="advies-step__text">
                        <strong>Beschrijf uw situatie</strong>
                        <p>Vertel ons wat het type steen is en wat u wilt bereiken of welk probleem u heeft</p>
                    </div>
                </div>
                <div class="advies-step">
                    <div class="advies-step__num">3</div>
                    <div class="advies-step__text">
                        <strong>Ontvang persoonlijk advies</strong>
                        <p>Binnen 24 uur krijgt u een gedetailleerd advies van onze experts</p>
                    </div>
                </div>
                <div class="advies-step">
                    <div class="advies-step__num">4</div>
                    <div class="advies-step__text">
                        <strong>Bestel direct</strong>
                        <p>Bestel de aanbevolen producten direct via de link in uw advies</p>
                    </div>
                </div>
            </div>

            <div class="waarom-box">
                <div class="waarom-box__title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <strong>Waarom kiezen voor ons advies?</strong>
                </div>
                <ul>
                    <li>Meer dan 15 jaar ervaring</li>
                    <li>Gecertificeerde natuursteen specialisten</li>
                    <li>Onafhankelijk advies</li>
                    <li>Gratis en vrijblijvend</li>
                </ul>
            </div>
        </div>

        <div class="advies-card">
            <h2>Advies aanvragen</h2>

            <?php if (!empty($_SESSION['user'])): ?>

                <?php if (!empty($existing)): ?>
                    <div class="existing-notice">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <p>U heeft al een adviesaanvraag ingediend.</p>
                        <a href="/show-advies/<?= $existing['id'] ?>" class="advies-submit" style="text-align:center; display:block;">
                            Bekijk uw aanvraag
                        </a>
                    </div>
                <?php else: ?>

                    <div class="form-group">
                        <label>Uw naam <span class="req">*</span></label>
                        <input type="text" id="adv-name" placeholder="Volledige naam"
                               value="<?= htmlspecialchars($_SESSION['user']['username']) ?>">
                    </div>

                    <div class="form-group">
                        <label>E-mailadres <span class="req">*</span></label>
                        <input type="email" id="adv-email" placeholder="uw@email.nl"
                               value="<?= htmlspecialchars($_SESSION['user']['email']) ?>">
                    </div>

                    <div class="form-group">
                        <label>Telefoonnummer</label>
                        <input type="tel" id="adv-phone" placeholder="06 12345678">
                    </div>

                    <div class="form-group">
                        <label>Type natuursteen</label>
                        <input type="text" id="adv-stone-type">
                    </div>

                    <div class="form-group">
                        <label>Waar bevindt de steen zich?</label>
                        <input type="text" id="adv-stone-location">
                    </div>

                    <div class="form-group">
                        <label>Beschrijf uw vraag of probleem <span class="req">*</span></label>
                        <textarea id="adv-message" placeholder="Beschrijf zo gedetailleerd mogelijk wat u wilt bereiken of welk probleem u heeft..."></textarea>
                    </div>

                    <div>
                        <span class="upload-label">Upload foto's (max 5 stuks)</span>
                        <label class="upload-zone">
                            <input type="file" id="adv-photos" accept="image/*" multiple>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <p>Sleep uw foto's hierheen of klik om te uploaden</p>
                            <span>JPG, PNG of HEIC; maximaal 10MB per foto</span>
                        </label>
                    </div>

                    <button id="adv-submit" class="advies-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Verstuur adviesaanvraag
                    </button>

                    <p class="submit-note">Gemiddelde reactietijd: 4 uur op werkdagen</p>

                <?php endif; ?>

            <?php else: ?>
                <div class="login-notice">
                    <p>U moet ingelogd zijn om een adviesaanvraag te doen.</p>
                    <a href="/login" class="advies-submit" style="text-align:center; display:block;">Inloggen</a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>

<!-- CONTACT CARDS -->
<section class="contact-section">
    <div class="contact-grid">

        <div class="contact-card">
            <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <h3>E-mail advies</h3>
            <p>Uitgebreid schriftelijk advies met productaanbevelingen</p>
            <span class="contact-time">Binnen 24 uur</span>
        </div>

        <div class="contact-card">
            <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.58 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.77a16 16 0 0 0 6.29 6.29l1.62-1.62a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </div>
            <h3>Telefonisch contact</h3>
            <p>Direct persoonlijk contact voor urgente vragen</p>
            <span class="contact-time">Ma–Vr 9:00–17:00</span>
        </div>

        <div class="contact-card">
            <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h3>Chat support</h3>
            <p>Live chat met onze experts voor snelle vragen</p>
            <span class="contact-time">Ma–Vr 9:00–21:00</span>
        </div>

    </div>
</section>
<?php require_once __DIR__ . '/../component/footer.php'; ?>

<script src="/public/js/advies.js"></script>

</body>
</html>