document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('adv-submit');

    // Animate elements when they come into view using IntersectionObserver
    const animateSelector = [
        '.page-title',
        '.advies-left',
        '.advies-card',
        '.advies-step',
        '.upload-zone',
        '.contact-card'
    ].join(',');

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -10% 0px',
        threshold: 0.12
    };

    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                obs.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll(animateSelector).forEach(el => io.observe(el));

    const pageTitle = document.querySelector('.page-title');
    if (pageTitle) {
        setTimeout(() => pageTitle.classList.add('in-view'), 120);
    }

    // foto preview
    const photosInput = document.getElementById('adv-photos');
    if (photosInput) {
        photosInput.addEventListener('change', () => {
            const existing = document.getElementById('adv-preview');
            if (existing) existing.remove();

            const files = Array.from(photosInput.files);

            if (files.length > 5) {
                showAlert({
                    type: 'error',
                    title: 'Niet Gelukt!',
                    message: 'U kunt maximaal 5 foto\'s uploaden.'
                });
                photosInput.value = '';
                return;
            }

            if (!files.length) return;

            const preview = document.createElement('div');
            preview.id = 'adv-preview';
            preview.className = 'adv-preview';

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const item = document.createElement('div');
                    item.className = 'adv-preview__item';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;

                    const name = document.createElement('span');
                    name.textContent = file.name.length > 20
                        ? file.name.substring(0, 17) + '...'
                        : file.name;

                    item.appendChild(img);
                    item.appendChild(name);
                    preview.appendChild(item);
                };
                reader.readAsDataURL(file);
            });

            photosInput.closest('div').appendChild(preview);
        });
    }

    if (!btn) return;

    btn.addEventListener('click', async () => {
        const name    = document.getElementById('adv-name')?.value.trim();
        const email   = document.getElementById('adv-email')?.value.trim();
        const message = document.getElementById('adv-message')?.value.trim();

        if (!name || !email || !message) {

            showAlert({
                type: 'error',
                title: 'Niet Gelukt!',
                message: 'Vul alle verplichte velden in.'
            });
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