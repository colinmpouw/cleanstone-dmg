<?php
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header('Location: /login');
    exit;
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn Account — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
        <link rel="stylesheet" href="/public/css/footer.css">
        <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="/public/css/account.css">
</head>
<body>
<?php include __DIR__ . '/../component/header.php'; ?>
<main class="account-page">
    <div class="account-grid">
        <aside class="account-sidebar">
            <div class="profile-card">
                <div class="profile-avatar"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></div>
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <nav class="account-menu">
                <a class="active" href="/account">Overzicht</a>
                <a href="/account?section=bestellingen">Bestellingen</a>
                <a class="logout-link" href="/logout">Uitloggen</a>
            </nav>
        </aside>

        <section class="account-content">
            <div class="account-header">
                <div>
                    <p class="eyebrow">Mijn Account</p>
                    <h1>Welkom terug, <?php echo htmlspecialchars($user['username']); ?></h1>
                </div>
                <div class="account-cta">
                    <a class="btn-outline" href="/logout">Uitloggen</a>
                </div>
            </div>

            <div class="stats-grid">
                <article class="stat-card">
                    <span class="stat-number">5</span>
                    <p>Bestellingen</p>
                </article>
                <article class="stat-card">
                    <span class="stat-number">1</span>
                    <p>Adviesaanvraag</p>
                </article>
                <article class="stat-card">
                    <span class="stat-number">1</span>
                    <p>Berichten</p>
                </article>
            </div>

            <div class="highlight-card">
                <h2>Uw adviesaanvraag is in behandeling</h2>
                <p>Onze specialist bekijkt uw aanvraag. U ontvangt binnen 24 uur een reactie.</p>
                <a class="btn-primary" href="/advies">Bekijk adviesaanvraag</a>
            </div>

            <div class="recent-orders">
                <div class="section-head">
                    <h2>Recente bestellingen</h2>
                </div>
                <div class="order-card">
                    <div>
                        <h3>Bestelling #1001</h3>
                        <p>15 maart 2024 • €89,95</p>
                    </div>
                    <span class="order-status shipped">Verzonden</span>
                </div>
                <div class="order-card">
                    <div>
                        <h3>Bestelling #1002</h3>
                        <p>15 maart 2024 • €89,95</p>
                    </div>
                    <span class="order-status shipped">Verzonden</span>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include __DIR__ . '/../component/footer.php'; ?>
</body>
</html>
