<?php
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
    <title>Inloggen — CleanStone</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/auth.css">
</head>
<body>
<?php include __DIR__ . '/../component/header.php'; ?>
<main class="auth-page">
    <div class="auth-card">
        <div class="auth-card__header">
            <p class="eyebrow">Welkom terug</p>
            <h1>Log in op uw account</h1>
            <p>Gebruik uw e-mailadres en wachtwoord om verder te gaan.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="auth-alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="post" class="auth-form">
            <label for="email">E-mailadres</label>
            <input id="email" type="email" name="email" value="<?php echo $oldEmail; ?>" required>

            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" required>

            <button type="submit" class="btn-primary">Inloggen</button>

            <p class="auth-secondary">Nog geen account? <a href="/register">Registreer hier</a></p>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../component/footer.php'; ?>
</body>
</html>
