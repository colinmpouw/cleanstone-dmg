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

        <!-- LOGO -->
        <div class="auth-logo">
            <a href="/home">
                <img src="/public/assets/logo-cleanstone.png" alt="CleanStone">
            </a>
        </div>

        <!-- HEADER -->
        <div class="auth-card__header">
            <h1>Welkom terug</h1>
            <p>Log in om uw account te beheren</p>
        </div>

        <!-- ERRORS -->
        <?php if (!empty($errors)): ?>
            <div class="auth-alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="/login" method="post" class="auth-form">

            <div class="form-group">
                <label for="email">E-mailadres</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($oldEmail); ?>" placeholder="uw@email.nl" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input id="password" type="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-pw" onclick="togglePassword()" tabindex="-1">
                        <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="auth-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Onthoud mij</span>
                </label>
                <a href="/wachtwoord-vergeten" class="forgot-link">Wachtwoord vergeten?</a>
            </div>

            <button type="submit" class="auth-submit">
                Inloggen
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>

        </form>

        <p class="auth-secondary">Nog geen account? <a href="/register">Registreer hier</a></p>

    </div>
</main>

<?php include __DIR__ . '/../component/footer.php'; ?>
</body>
</html>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
</script>