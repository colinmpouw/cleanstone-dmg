let userId = null;
let verifiedToken = null;

// ── CODE VAKJES ──
const digits = document.querySelectorAll('.code-digit');
const hidden = document.getElementById('reset-code');

digits.forEach((input, i) => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value && i < digits.length - 1) digits[i + 1].focus();
        hidden.value = [...digits].map(d => d.value).join('');
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && i > 0) digits[i - 1].focus();
    });

    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
        [...text].forEach((char, j) => { if (digits[j]) digits[j].value = char; });
        hidden.value = text;
        const next = digits[Math.min(text.length, digits.length - 1)];
        if (next) next.focus();
    });
});

// ── HELPER: fout tonen ──
function showError(id, message) {
    const el = document.getElementById(id);
    el.textContent = message;
    el.style.display = 'block';
}

function clearError(id) {
    const el = document.getElementById(id);
    el.textContent = '';
    el.style.display = 'none';
}

// ── HELPER: stap wisselen ──
function goToStep(from, to) {
    document.getElementById(from).style.display = 'none';
    document.getElementById(to).style.display   = 'block';
}

// goBack wordt gebruikt via onclick in de HTML
function goBack(from, to) {
    goToStep(from, to);
}

// ── WACHTWOORD TOGGLE ──
function wwToggle(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}

// ── STAP 1 — email versturen ──
document.getElementById('btn-send-code').addEventListener('click', async () => {
    const email = document.getElementById('reset-email').value.trim();
    clearError('stap-1-error');

    if (!email) {
        showError('stap-1-error', 'Vul uw e-mailadres in.');
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
        goToStep('stap-1', 'stap-2');
        if (digits.length) digits[0].focus();
    } else {
        showError('stap-1-error', data.message);
    }
});

// ── STAP 2 — code verifiëren ──
document.getElementById('btn-verify-code').addEventListener('click', async () => {
    const token = document.getElementById('reset-code').value.trim();
    clearError('stap-2-error');

    if (!token || token.length < 6) {
        showError('stap-2-error', 'Vul de volledige code in.');
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
        goToStep('stap-2', 'stap-3');
    } else {
        showError('stap-2-error', data.message);
    }
});

// ── WACHTWOORD TOGGLE ──
function wwToggle(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}

// ── STAP 3 — wachtwoord resetten ──
document.getElementById('btn-reset-password').addEventListener('click', async () => {
    const password        = document.getElementById('reset-password').value.trim();
    const passwordConfirm = document.getElementById('reset-password-confirm').value.trim();
    clearError('stap-3-error');

    if (!password || password.length < 6) {
        showError('stap-3-error', 'Wachtwoord moet minimaal 6 tekens zijn.');
        return;
    }

    if (password !== passwordConfirm) {
        showError('stap-3-error', 'Wachtwoorden komen niet overeen.');
        return;
    }

    const res  = await fetch('/api/reset/reset-password', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, token: verifiedToken, password })
    });
    const data = await res.json();

    if (data.success) {
        goToStep('stap-3', 'stap-4');
    } else {
        showError('stap-3-error', data.message);
    }
});