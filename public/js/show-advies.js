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

    // chat image upload
    const imageInput = document.getElementById('chat-image-input');
    if (imageInput) {
        imageInput.addEventListener('change', async () => {
            const file = imageInput.files[0];
            if (!file) return;

            const caption = input?.value.trim() || '';
            if (input) input.value = '';
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

        // render image gallery
        const gallery = document.getElementById('adv-gallery');
        if (gallery && count > 0) {
            gallery.innerHTML = '';
            data.images.forEach(img => {
                const a = document.createElement('a');
                a.href   = `/uploads/advies/${img.filename}`;
                a.target = '_blank';
                a.className = 'adv-gallery__item';

                const el = document.createElement('img');
                el.src = `/uploads/advies/${img.filename}`;
                el.alt = 'Bijgevoegde foto';

                a.appendChild(el);
                gallery.appendChild(a);
            });
        }

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

            let bubbleContent = '';
            if (m.image_filename) {
                bubbleContent += `<a href="/uploads/advies/${m.image_filename}" target="_blank"><img class="msg__img" src="/uploads/advies/${m.image_filename}" alt="foto"></a>`;
            }
            if (m.message) {
                bubbleContent += `<span class="msg__text">${escapeHtml(m.message)}</span>`;
            }

            div.innerHTML = `
                <div class="msg__bubble">${bubbleContent}</div>
                <span class="msg__time">${isAdmin ? 'CleanStone' : m.username} · ${time}</span>
            `;
            container.appendChild(div);
        });

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

function escapeHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}