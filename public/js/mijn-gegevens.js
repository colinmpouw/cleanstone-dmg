// laad gebruikersgegevens
async function loadGegevens() {
    try {
        const res  = await fetch('/api/account/gegevens');
        const data = await res.json();
        if (!data.success) return;

        document.getElementById('g-username').value = data.data.username || '';
        document.getElementById('g-email').value    = data.data.email    || '';
        document.getElementById('g-phone').value    = data.data.phone    || '';
    } catch (err) {
        console.error(err);
    }
}

loadGegevens();


function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `toast toast--${type}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => {
        t.classList.remove('show');
        setTimeout(() => t.remove(), 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {

    // profiel opslaan
    document.getElementById('btn-save-profiel')?.addEventListener('click', async () => {
        const payload = {
            username: document.getElementById('g-username')?.value.trim(),
            email:    document.getElementById('g-email')?.value.trim(),
            phone:    document.getElementById('g-phone')?.value.trim(),
        };

        if (!payload.username || !payload.email) {
            toast('Gebruikersnaam en e-mail zijn verplicht', 'error');
            return;
        }

        try {
            const res  = await fetch('/api/account/mijn-gegevens/profiel', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            toast(data.message, data.success ? 'success' : 'error');
        } catch (err) {
            toast('Er is iets misgegaan', 'error');
        }
    });
});