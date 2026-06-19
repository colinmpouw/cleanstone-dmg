let userId = null;
let verifiedToken = null;

// STAP 1 — email versturen
document.getElementById('btn-send-code').addEventListener('click', async () => {
    const email = document.getElementById('reset-email').value.trim();
    const error = document.getElementById('stap-1-error');

    if (!email) {
        error.textContent = 'Vul uw e-mailadres in.';
        error.style.display = 'block';
        return;
    }

    const res  = await fetch('/api/reset/send-code', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email })
    });
    const data = await res.json();

    if (data.success) {
        userId = data.user_id;
        document.getElementById('stap-1').style.display = 'none';
        document.getElementById('stap-2').style.display = 'block';
    } else {
        error.textContent = data.message;
        error.style.display = 'block';
    }
});

// STAP 2 — code verifiëren
document.getElementById('btn-verify-code').addEventListener('click', async () => {
    const token = document.getElementById('reset-code').value.trim();
    const error = document.getElementById('stap-2-error');

    if (!token) {
        error.textContent = 'Vul de code in.';
        error.style.display = 'block';
        return;
    }

    const res  = await fetch('/api/reset/verify-code', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, token })
    });
    const data = await res.json();

    if (data.success) {
        verifiedToken = token;
        document.getElementById('stap-2').style.display = 'none';
        document.getElementById('stap-3').style.display = 'block';
    } else {
        error.textContent = data.message;
        error.style.display = 'block';
    }
});

// STAP 3 — wachtwoord resetten
document.getElementById('btn-reset-password').addEventListener('click', async () => {
    const password        = document.getElementById('reset-password').value.trim();
    const passwordConfirm = document.getElementById('reset-password-confirm').value.trim();
    const error           = document.getElementById('stap-3-error');

    if (!password || password.length < 6) {
        error.textContent = 'Wachtwoord moet minimaal 6 tekens zijn.';
        error.style.display = 'block';
        return;
    }

    if (password !== passwordConfirm) {
        error.textContent = 'Wachtwoorden komen niet overeen.';
        error.style.display = 'block';
        return;
    }

    const res  = await fetch('/api/reset/reset-password', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, token: verifiedToken, password })
    });
    const data = await res.json();

    if (data.success) {
        document.getElementById('stap-3').style.display = 'none';
        document.getElementById('stap-4').style.display = 'block';
    } else {
        error.textContent = data.message;
        error.style.display = 'block';
    }
});