const modal      = document.getElementById('addressModal');
const modalTitle = document.getElementById('modal-title');
let editingId    = null;

// ── Toast ──
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

// ── Modal ──
document.getElementById('openModal').onclick = () => {
    editingId = null;
    modalTitle.textContent = 'Nieuw adres toevoegen';
    document.getElementById('addr-form').reset();
    modal.classList.add('show');
};

function closeModal() {
    modal.classList.remove('show');
    document.getElementById('addr-form').reset();
    editingId = null;
}

modal.addEventListener('click', e => {
    if (e.target === modal) closeModal();
});

// ── Load adressen ──
async function loadAddresses() {
    const container = document.getElementById('addresses-container');
    container.innerHTML = '<p style="color:var(--rustic-taupe)">Laden...</p>';

    try {
        const res  = await fetch('/api/get_all_addresses');
        const data = await res.json();

        if (!data.success || !data.data.length) {
            container.innerHTML = '<p style="color:var(--rustic-taupe)">Geen adressen gevonden.</p>';
            return;
        }

        container.innerHTML = '';

        data.data.forEach(addr => {
            const isDefault = addr.invoice_address == 1;
            const card = document.createElement('div');
            card.className = 'address-card' + (isDefault ? ' default' : '');

            card.innerHTML = `
                <div class="address-left">
                    <div class="address-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M10 14V8.66667C10 8.48986 9.92976 8.32029 9.80474 8.19526C9.67971 8.07024 9.51014 8 9.33333 8H6.66667C6.48986 8 6.32029 8.07024 6.19526 8.19526C6.07024 8.32029 6 8.48986 6 8.66667V14" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.66673C1.99995 6.47277 2.04222 6.28114 2.12386 6.1052C2.20549 5.92927 2.32453 5.77326 2.47267 5.64806L7.13933 1.64873C7.37999 1.44533 7.6849 1.33374 8 1.33374C8.3151 1.33374 8.62001 1.44533 8.86067 1.64873L13.5273 5.64806C13.6755 5.77326 13.7945 5.92927 13.8761 6.1052C13.9578 6.28114 14 6.47277 14 6.66673V12.6667C14 13.0203 13.8595 13.3595 13.6095 13.6095C13.3594 13.8596 13.0203 14.0001 12.6667 14.0001H3.33333C2.97971 14.0001 2.64057 13.8596 2.39052 13.6095C2.14048 13.3595 2 13.0203 2 12.6667V6.66673Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="address-title">
                            <h3>${addr.first_name} ${addr.last_name}</h3>
                            ${isDefault ? '<span class="badge">Standaard</span>' : ''}
                        </div>
                        <div class="address-info">
                            <p>${addr.street} ${addr.house_number}</p>
                            <p>${addr.postal_code} ${addr.city}</p>
                            <p>${addr.country}</p>
                            ${addr.phone ? `<p>${addr.phone}</p>` : ''}
                            ${!isDefault ? `<span class="set-default" data-id="${addr.id}">Instellen als standaard</span>` : ''}
                        </div>
                    </div>
                </div>
                <div class="address-actions">
                    <button class="icon-btn edit-btn" data-id="${addr.id}">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <g clip-path="url(#editClip)">
                                <path d="M18.3513 9.97373C18.6597 9.66539 18.833 9.24717 18.8331 8.81106C18.8331 8.37495 18.6599 7.95668 18.3516 7.64827C18.0433 7.33985 17.625 7.16656 17.1889 7.1665C16.7528 7.16645 16.3345 7.33964 16.0261 7.64798L8.24097 15.4349C8.10553 15.5699 8.00537 15.7362 7.9493 15.9191L7.17872 18.4577C7.16364 18.5082 7.1625 18.5618 7.17542 18.6128C7.18834 18.6638 7.21484 18.7104 7.2521 18.7476C7.28936 18.7848 7.33599 18.8113 7.38706 18.8241C7.43812 18.8369 7.49171 18.8357 7.54213 18.8206L10.0814 18.0506C10.2641 17.995 10.4303 17.8954 10.5655 17.7606L18.3513 9.97373Z"
                                      stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs><clipPath id="editClip"><rect width="14" height="14" fill="white" transform="translate(6 6)"/></clipPath></defs>
                        </svg>
                    </button>
                    <button class="icon-btn delete-btn" data-id="${addr.id}">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <path d="M7.75 9.5H18.25" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.0832 9.5V17.6667C17.0832 18.25 16.4998 18.8333 15.9165 18.8333H10.0832C9.49984 18.8333 8.9165 18.25 8.9165 17.6667V9.5" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6665 9.50008V8.33341C10.6665 7.75008 11.2498 7.16675 11.8332 7.16675H14.1665C14.7498 7.16675 15.3332 7.75008 15.3332 8.33341V9.50008" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.8335 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.1665 12.4167V15.9167" stroke="#7E6A52" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(card);
        });

        // edit
        container.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const res  = await fetch(`/api/adressen/${btn.dataset.id}`);
                const data = await res.json();
                if (!data.success) { toast('Kon adres niet laden', 'error'); return; }

                const a = data.data;
                editingId = a.id;
                modalTitle.textContent = 'Adres bewerken';

                document.getElementById('addr-first-name').value  = a.first_name || '';
                document.getElementById('addr-last-name').value   = a.last_name  || '';
                document.getElementById('addr-street').value      = a.street     || '';
                document.getElementById('addr-house-number').value = a.house_number || '';
                document.getElementById('addr-postal-code').value = a.postal_code || '';
                document.getElementById('addr-city').value        = a.city       || '';
                document.getElementById('addr-country').value     = a.country    || 'Nederland';
                document.getElementById('addr-phone').value       = a.phone      || '';

                modal.classList.add('show');
            });
        });

        // delete
        container.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                if (!confirm('Weet u zeker dat u dit adres wilt verwijderen?')) return;
                const res  = await fetch('/api/adressen/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: btn.dataset.id })
                });
                const data = await res.json();
                if (data.success) {
                    toast('Adres verwijderd');
                    loadAddresses();
                } else {
                    toast('Verwijderen mislukt', 'error');
                }
            });
        });

        // set default
        container.querySelectorAll('.set-default').forEach(btn => {
            btn.addEventListener('click', async () => {
                const res  = await fetch('/api/adressen/default', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: btn.dataset.id })
                });
                const data = await res.json();
                if (data.success) {
                    toast('Standaard adres ingesteld');
                    loadAddresses();
                } else {
                    toast('Instellen mislukt', 'error');
                }
            });
        });

    } catch (err) {
        console.error(err);
        toast('Kon adressen niet laden', 'error');
    }
}

// ── Submit (nieuw of edit) ──
document.getElementById('save-address-btn').addEventListener('click', async () => {
    const get = id => document.getElementById(id)?.value.trim();

    const payload = {
        first_name:   get('addr-first-name'),
        last_name:    get('addr-last-name'),
        street:       get('addr-street'),
        house_number: get('addr-house-number'),
        postal_code:  get('addr-postal-code'),
        city:         get('addr-city'),
        country:      get('addr-country') || 'Nederland',
        phone:        get('addr-phone'),
        invoice_address: document.getElementById('addr-default')?.checked ? 1 : 0,
    };

    // validatie
    const labels = {
        first_name: 'Voornaam', last_name: 'Achternaam', street: 'Straat',
        house_number: 'Huisnummer', postal_code: 'Postcode', city: 'Stad',
        phone: 'Telefoonnummer'
    };

    for (const [key, label] of Object.entries(labels)) {
        if (!payload[key]) {
            toast(`${label} is verplicht`, 'error');
            return;
        }
    }

    try {
        let url  = '/api/add_address';
        let body = payload;

        if (editingId) {
            url  = '/api/adressen/update';
            body = { ...payload, id: editingId };
        }

        const res  = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });
        const data = await res.json();

        if (data.success) {
            toast(editingId ? 'Adres bijgewerkt' : 'Adres toegevoegd');
            closeModal();
            loadAddresses();
        } else {
            toast(data.message || 'Er is iets misgegaan', 'error');
        }
    } catch (err) {
        console.error(err);
        toast('Er is iets misgegaan', 'error');
    }
});

document.addEventListener('DOMContentLoaded', loadAddresses);