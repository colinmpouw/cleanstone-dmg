const adviesId = window.advies_id;

document.addEventListener('DOMContentLoaded', async () => {
    if (!adviesId) return;

    await loadChatInfo();
    await loadMessages();
    setInterval(loadMessages, 5000);

    const input   = document.getElementById('chatInput');
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

    // image upload in chat
    const imageInput = document.getElementById('chatImageInput');
    if (imageInput) {
        imageInput.addEventListener('change', async () => {
            const file = imageInput.files[0];
            if (!file) return;

            const caption = input?.value.trim() || '';
            if (input) { input.value = ''; input.style.height = '40px'; }
            imageInput.value = '';

            const formData = new FormData();
            formData.append('request_id', adviesId);
            formData.append('message', caption);
            formData.append('image', file);

            try {
                const res  = await fetch('/api/advies/message/upload', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) await loadMessages();
            } catch (err) {
                console.error(err);
            }
        });
    }
});

async function loadChatInfo() {
    document.querySelector('.chat-header').classList.add('chat-header--loading');

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

        // render submitted images strip
        if (data.images && data.images.length > 0) {
            const strip = document.getElementById('advImagesStrip');
            const grid  = document.getElementById('advImagesGrid');
            strip.style.display = '';
            data.images.forEach(img => {
                const a = document.createElement('a');
                a.href   = `/uploads/advies/${img.filename}`;
                a.target = '_blank';
                a.className = 'adv-strip-img';

                const el = document.createElement('img');
                el.src = `/uploads/advies/${img.filename}`;
                el.alt = 'Bijgevoegde foto';

                a.appendChild(el);
                grid.appendChild(a);
            });
        }

    } catch (err) {
        console.error(err);
    } finally {
        document.querySelector('.chat-header').classList.remove('chat-header--loading');
    }
}

let lastCount = 0;

async function loadMessages() {
    try {
        const res  = await fetch(`/api/advies/${adviesId}/messages`);
        const msgs = await res.json();

        if (msgs.length === lastCount) return;

        const isInitialLoad = lastCount === 0;
        lastCount = msgs.length;

        const container = document.getElementById('chatMessages');
        container.innerHTML = '';

        msgs.forEach((m, index) => {
            const isAdmin = m.role === 'admin';
            const time = new Date(m.created_at).toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
            const initials = m.username.substring(0, 2).toUpperCase();

            const group = document.createElement('div');
            group.className = 'msg-group' + (isAdmin ? ' msg-group--right' : '') + ' msg-group--enter';

            let bubbleContent = '';
            if (m.image_filename) {
                bubbleContent += `<a href="/uploads/advies/${m.image_filename}" target="_blank" class="msg-image"><img src="/uploads/advies/${m.image_filename}" alt="foto"></a>`;
            }
            if (m.message) {
                bubbleContent += `<div class="msg-bubble">${escapeHtml(m.message)}</div>`;
            }

            if (isAdmin) {
                group.innerHTML = `
                    <div class="msg-bubbles">
                        ${bubbleContent}
                        <span class="msg-meta">CleanStone · ${time}</span>
                    </div>
                    <div class="msg-avatar msg-avatar--cs">CS</div>
                `;
            } else {
                group.innerHTML = `
                    <div class="msg-avatar msg-avatar--km">${initials}</div>
                    <div class="msg-bubbles">
                        ${bubbleContent}
                        <span class="msg-meta">${escapeHtml(m.username)} · ${time}</span>
                    </div>
                `;
            }

            group.style.animationDelay = isInitialLoad ? `${index * 35}ms` : '0ms';
            group.addEventListener('animationend', () => {
                group.classList.remove('msg-group--enter');
                group.style.animationDelay = '';
            }, { once: true });

            container.appendChild(group);
        });

        container.scrollTop = container.scrollHeight;

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

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}