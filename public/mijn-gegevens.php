<?php
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header('Location: /login');
    exit;
}
$initial = strtoupper(substr($user['username'] ?? $user['name'] ?? 'U', 0, 1)) .
    strtoupper(substr(explode(' ', $user['username'] ?? $user['name'] ?? 'U')[1] ?? '', 0, 1));
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/sidebarAccount.css">
    <link rel="stylesheet" href="/public/css/mijn-gegevens.css">
    <title>Cleanstone -Mijn gegevens</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
</head>
<body>
<?php require_once __DIR__ . '/../component/header.php'; ?>

<div class="account-layout">

    <?php require_once __DIR__ . '/../component/sidebarAccount.php'; ?>

    <main class="gegevens-main">

        <h1>Persoonlijke gegevens</h1>

        <!-- PROFILE HEADER CARD -->
        <div class="profile-header-card">
            <div class="profile-avatar"><?= htmlspecialchars($initial) ?></div>
            <div class="profile-header-info">
                <strong><?= htmlspecialchars($user['username'] ?? $user['name'] ?? '') ?></strong>
                <span><?= htmlspecialchars($user['email'] ?? '') ?></span>
            </div>
        </div>

        <!-- BASISGEGEVENS -->
        <div class="gegevens-card">
            <h2>Basisgegevens</h2>

            <div class="gegevens-form">
                <div class="form-group">
                    <label>Gebruikersnaam</label>
                    <input type="text" id="g-username" placeholder="Gebruikersnaam">
                </div>
                <div class="form-group">
                    <label>E-mailadres</label>
                    <input type="email" id="g-email" placeholder="uw@email.nl">
                </div>
                <div class="form-group">
                    <label>Telefoonnummer</label>
                    <input type="tel" id="g-phone" placeholder="+31 6 12345678">
                </div>

                <div class="form-footer">
                    <button class="btn-save" id="btn-save-profiel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Opslaan
                    </button>
                </div>
            </div>
        </div>

    </main>
</div>

<?php require_once __DIR__ . '/../component/footer.php'; ?>
<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/mijn-gegevens.js"></script>
</body>
</html>