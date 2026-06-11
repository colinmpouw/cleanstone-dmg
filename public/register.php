<?php
if (!isset($oldUsername)) {
    $oldUsername = '';
}
if (!isset($oldEmail)) {
    $oldEmail = '';
}
if (!isset($errors)) {
    $errors = [];
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registreren — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
        <link rel="stylesheet" href="/public/css/footer.css">
        <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="/public/css/auth.css">
</head>
<body>
<?php include __DIR__ . '/../component/header.php'; ?>
<main class="auth-page">
    <div class="auth-card">
        <div class="auth-card__header">
            <p class="eyebrow">Nieuw account</p>
            <h1>Registreer uw account</h1>
            <p>Maak een account aan om uw dashboard en bestellingen te beheren.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="auth-alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="post" class="auth-form">
            <label for="username">Gebruikersnaam</label>
            <input id="username" type="text" name="username" value="<?php echo $oldUsername; ?>" required>

            <label for="email">E-mailadres</label>
            <input id="email" type="email" name="email" value="<?php echo $oldEmail; ?>" required>

            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" required>

            <label for="confirm_password">Herhaal wachtwoord</label>
            <input id="confirm_password" type="password" name="confirm_password" required>

            <button type="submit" class="btn-primary">Account aanmaken</button>

            <p class="auth-secondary">Al een account? <a href="/login">Log hier in</a></p>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../component/footer.php'; ?>
</body>
</html>
