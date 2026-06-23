const adviesId = window.advies_id;

document.addEventListener('DOMContentLoaded', async () => {
    if (!adviesId) return;
    await loadAdvies();
    await loadMessages();

    setInterval(loadMessages, 5000);

    const input = document.getElementById('chat-input');
    const btn   = document.getElementById('chat-send');

    if (input) {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }
    if (btn) btn.addEventListener('click', sendMessage);

    // delete
    const deleteBtn = document.getElementById('adv-delete');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', async () => {
            if (!confirm('Weet u zeker dat u uw adviesaanvraag wilt verwijderen?')) return;

            try {
                const res  = await fetch('/api/advies/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: adviesId })
                });
                const data = await res.json();

                if (data.success) {
                    window.location.href = '/show-advies';
                } else {
                    alert('Verwijderen mislukt.');
                }
            } catch (err) {
                console.error(err);
            }
        });
    }
});

async function loadAdvies() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}`);
        const data = await res.json();
        if (!data.success) return;

        const r = data.data;

        document.getElementById('adv-title').textContent = r.stone_type
            ? `${r.stone_type} — ${r.stone_location || ''}`
            : 'Adviesaanvraag';

        document.getElementById('adv-date').textContent = new Date(r.created_at).toLocaleString('nl-NL');

        const statusPill = document.getElementById('adv-status');
        statusPill.textContent = r.status === 'open' ? 'Open'
            : r.status === 'in_behandeling' ? 'In behandeling'
                : 'Gesloten';
        statusPill.className = 'status-pill status--' + r.status;

        document.getElementById('adv-stone-type').textContent     = r.stone_type || '—';
        document.getElementById('adv-stone-location').textContent = r.stone_location || '—';
        document.getElementById('adv-message').textContent        = r.message;

        const count = data.images.length;
        document.getElementById('adv-foto-count').textContent =
            count > 0 ? `${count} foto(s) bijgevoegd` : 'Geen foto\'s';

    } catch (err) {
        console.error(err);
    }
}

let lastMessageCount = 0;

async function loadMessages() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}/messages`);
        const msgs = await res.json();

        if (msgs.length === lastMessageCount) return;
        lastMessageCount = msgs.length;

        const container = document.getElementById('chat-messages');
        container.innerHTML = '';

        msgs.forEach(m => {
            const isAdmin = m.role === 'admin';
            const div = document.createElement('div');
            div.className = 'msg ' + (isAdmin ? 'msg--admin' : 'msg--user');

            const time = new Date(m.created_at).toLocaleTimeString('nl-NL', {
                hour: '2-digit', minute: '2-digit'
            });

            div.innerHTML = `
                <div class="msg__bubble">${m.message}</div>
                <span class="msg__time">${isAdmin ? 'CleanStone' : m.username} · ${time}</span>
            `;
            container.appendChild(div);
        });

        // auto scroll
        container.scrollTop = container.scrollHeight;

    } catch (err) {
        console.error(err);
    }
}

async function sendMessage() {
    const input   = document.getElementById('chat-input');
    const message = input?.value.trim();
    if (!message) return;

    input.value = '';

    try {
        const res  = await fetch('/api/advies/message', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ request_id: adviesId, message })
        });
        const data = await res.json();
        if (data.success) await loadMessages();
    } catch (err) {
        console.error(err);
    }
}