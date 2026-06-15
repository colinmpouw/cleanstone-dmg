document.addEventListener('DOMContentLoaded', async () => {
    const id = window.advies_id;
    if (!id) return;

    try {
        const res  = await fetch(`/api/advies/${id}`);
        const data = await res.json();

        if (!data.success) return;

        const r = data.data;

        // header
        document.getElementById('adv-title').textContent = r.stone_type
            ? `${r.stone_type} — ${r.stone_location || ''}`
            : 'Adviesaanvraag';

        document.getElementById('adv-date').textContent = new Date(r.created_at).toLocaleString('nl-NL');

        const statusPill = document.getElementById('adv-status');
        statusPill.textContent = r.status === 'open' ? 'Open'
            : r.status === 'in_behandeling' ? 'In behandeling'
                : 'Gesloten';
        statusPill.className = 'status-pill status--' + r.status;

        // detail
        document.getElementById('adv-stone-type').textContent  = r.stone_type || '—';
        document.getElementById('adv-stone-location').textContent = r.stone_location || '—';
        document.getElementById('adv-message').textContent     = r.message;

        // foto count
        const count = data.images.length;
        document.getElementById('adv-foto-count').textContent =
            count > 0 ? `${count} foto(s) bijgevoegd` : 'Geen foto\'s';

    } catch (err) {
        console.error(err);
    }
});

document.querySelector('.chat-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && this.value.trim()) {
        const messages = document.querySelector('.chat-messages');
        const msg = document.createElement('div');
        msg.className = 'msg msg--user';
        const now = new Date();
        const time = now.getHours() + ':' + String(now.getMinutes()).padStart(2,'0');
        msg.innerHTML = `<div class="msg__bubble">${this.value}</div><span class="msg__time">${time}</span>`;
        messages.appendChild(msg);
        this.value = '';
        messages.scrollTop = messages.scrollHeight;
    }
});