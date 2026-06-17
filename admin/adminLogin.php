<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Login</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminLogin.css">
</head>
<body>

<!-- LEFT -->
<div class="left">
    <div class="brand">
        <img src="/admin/assets/logo.png" alt="logo" >
    </div>

    <div class="left-quote">
        <div class="quote-mark">"</div>
        <p class="quote-text">Kwaliteit begint bij de juiste verzorging van steen.</p>
        <div class="quote-author">
            <div class="quote-author-line"></div>
            <span class="quote-author-name">CleanStone Admin</span>
        </div>
    </div>
</div>

<?php if (!empty($errorMessage)): ?>
    <div class="login-error">
        <?= htmlspecialchars($errorMessage) ?>
    </div>
<?php endif; ?>

<!-- RIGHT -->
<div class="right">
    <div class="form-wrap">
        <div class="form-heading">
            <h1>Inloggen</h1>
            <p>Voer uw beheerdersgegevens in</p>
        </div>

        <form action="/admin/login" method="POST">
            <div class="form-group">
                <label for="email">E-mailadres</label>
                <div class="input-wrap">
                    <input type="email" id="email" name="email" placeholder="admin@cleanstone.nl" autocomplete="email" required />
                </div>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required />
                    <button type="button" class="toggle-pw" aria-label="Wachtwoord tonen" onclick="togglePassword()">
                        <svg id="pw-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_543_49)">
                                <path d="M1.37468 7.768C1.31912 7.91767 1.31912 8.08232 1.37468 8.232C1.91581 9.54409 2.83435 10.666 4.01386 11.4554C5.19336 12.2448 6.58071 12.6663 8.00001 12.6663C9.41932 12.6663 10.8067 12.2448 11.9862 11.4554C13.1657 10.666 14.0842 9.54409 14.6253 8.232C14.6809 8.08232 14.6809 7.91767 14.6253 7.768C14.0842 6.4559 13.1657 5.33402 11.9862 4.5446C10.8067 3.75517 9.41932 3.33374 8.00001 3.33374C6.58071 3.33374 5.19336 3.75517 4.01386 4.5446C2.83435 5.33402 1.91581 6.4559 1.37468 7.768Z" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_543_49">
                                    <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>

                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">Inloggen</button>
        </form>
        <a href="/" class="back-link">← Terug naar de webshop</a>
    </div>
</div>

<script src="/admin/js/adminLogin.js"></script>
</body>
</html>