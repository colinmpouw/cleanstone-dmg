const adviesId = window.advies_id;

document.addEventListener('DOMContentLoaded', async () => {
    if (!adviesId) return;

    await loadChatInfo();
    await loadMessages();
    setInterval(loadMessages, 5000);

    const input  = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    input.addEventListener('input', () => {
        input.style.height = '40px';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });
});

async function loadChatInfo() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}`);
        const data = await res.json();
        if (!data.success) return;

        const r = data.data;

        document.querySelector('.chat-header__info h3').textContent = r.username;
        document.querySelector('.chat-header__info span').textContent =
            `${r.stone_type || '—'} · ${r.email}`;

        const initials = r.username.substring(0, 2).toUpperCase();
        document.querySelector('.chat-header__avatar').textContent = initials;

        const statusPill = document.querySelector('.status-pill');
        statusPill.textContent = r.status === 'open' ? 'Nieuw'
            : r.status === 'in_behandeling' ? 'In behandeling'
                : 'Gesloten';

    } catch (err) {
        console.error(err);
    }
}

let lastCount = 0;

async function loadMessages() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}/messages`);
        const msgs = await res.json();

        if (msgs.length === lastCount) return;
        lastCount = msgs.length;

        const container = document.getElementById('chatMessages');
        container.innerHTML = '';

        msgs.forEach(m => {
            const isAdmin = m.role === 'admin';
            const time = new Date(m.created_at).toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
            const initials = m.username.substring(0, 2).toUpperCase();

            const group = document.createElement('div');
            group.className = 'msg-group' + (isAdmin ? ' msg-group--right' : '');

            if (isAdmin) {
                group.innerHTML = `
                    <div class="msg-bubbles">
                        <div class="msg-bubble">${m.message}</div>
                        <span class="msg-meta">CleanStone · ${time}</span>
                    </div>
                    <div class="msg-avatar msg-avatar--cs">CS</div>
                `;
            } else {
                group.innerHTML = `
                    <div class="msg-avatar msg-avatar--km">${initials}</div>
                    <div class="msg-bubbles">
                        <div class="msg-bubble">${m.message}</div>
                        <span class="msg-meta">${m.username} · ${time}</span>
                    </div>
                `;
            }

            container.appendChild(group);
        });

        container.scrollTop = container.scrollHeight;

        // update status naar in_behandeling als admin eerste keer reageert
        await updateStatusIfNeeded();

    } catch (err) {
        console.error(err);
    }
}

async function updateStatusIfNeeded() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}`);
        const data = await res.json();
        if (data.data?.status === 'open') {
            await fetch('/api/advies/status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: adviesId, status: 'in_behandeling' })
            });
        }
    } catch (err) {}
}

async function sendMessage() {
    const input   = document.getElementById('chatInput');
    const message = input?.value.trim();
    if (!message) return;

    input.value = '';
    input.style.height = '40px';

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