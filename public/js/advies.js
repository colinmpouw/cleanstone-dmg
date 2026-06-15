document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('adv-submit');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        const name    = document.getElementById('adv-name')?.value.trim();
        const email   = document.getElementById('adv-email')?.value.trim();
        const message = document.getElementById('adv-message')?.value.trim();

        if (!name || !email || !message) {
            alert('Vul alle verplichte velden in.');
            return;
        }

        const formData = new FormData();
        formData.append('name',           name);
        formData.append('email',          email);
        formData.append('phone',          document.getElementById('adv-phone')?.value.trim() || '');
        formData.append('stone_type',     document.getElementById('adv-stone-type')?.value.trim() || '');
        formData.append('stone_location', document.getElementById('adv-stone-location')?.value.trim() || '');
        formData.append('message',        message);

        const photos = document.getElementById('adv-photos')?.files;
        if (photos) {
            Array.from(photos).slice(0, 5).forEach(file => {
                formData.append('photos[]', file);
            });
        }

        btn.disabled = true;
        btn.textContent = 'Versturen...';

        try {
            const res  = await fetch('/api/advies/submit', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                window.location.href = '/show-advies/' + data.request_id;
            } else {
                alert(data.message || 'Er is iets misgegaan.');
                btn.disabled = false;
                btn.textContent = 'Verstuur adviesaanvraag';
            }
        } catch (err) {
            console.error(err);
            alert('Er is iets misgegaan.');
            btn.disabled = false;
            btn.textContent = 'Verstuur adviesaanvraag';
        }
    });
});