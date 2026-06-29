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

// ── Stars renderer ──
const STAR_FILLED = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81285 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4443 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" fill="#7E6A52" stroke="#7E6A52" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

const STAR_EMPTY = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.01789 0.863588C7.0471 0.804562 7.09223 0.754876 7.14819 0.720138C7.20414 0.6854 7.26869 0.666992 7.33455 0.666992C7.40041 0.666992 7.46496 0.6854 7.52092 0.720138C7.57687 0.754876 7.622 0.804562 7.65122 0.863588L9.19122 3.98292C9.29267 4.18823 9.44243 4.36586 9.62764 4.50056C9.81284 4.63525 10.028 4.723 10.2546 4.75625L13.6986 5.26025C13.7638 5.26971 13.8251 5.29724 13.8755 5.33972C13.926 5.38221 13.9635 5.43795 13.9839 5.50066C14.0043 5.56336 14.0067 5.63053 13.9909 5.69455C13.9752 5.75857 13.9418 5.81689 13.8946 5.86292L11.4039 8.28826C11.2396 8.44832 11.1167 8.64591 11.0458 8.86401C10.9748 9.08211 10.9579 9.31418 10.9966 9.54026L11.5846 12.9669C11.5961 13.0321 11.589 13.0993 11.5642 13.1607C11.5394 13.2221 11.4978 13.2753 11.4442 13.3143C11.3907 13.3532 11.3272 13.3763 11.2611 13.3809C11.1951 13.3854 11.129 13.3714 11.0706 13.3403L7.99189 11.7216C7.78903 11.6151 7.56334 11.5594 7.33422 11.5594C7.1051 11.5594 6.87941 11.6151 6.67655 11.7216L3.59855 13.3403C3.54011 13.3712 3.47415 13.3851 3.40819 13.3804C3.34222 13.3757 3.2789 13.3526 3.22542 13.3137C3.17193 13.2748 3.13044 13.2217 3.10566 13.1604C3.08087 13.0991 3.07379 13.0321 3.08522 12.9669L3.67255 9.54092C3.71135 9.31474 3.69454 9.08252 3.62358 8.86429C3.55261 8.64605 3.42963 8.44836 3.26522 8.28826L0.774553 5.86359C0.726949 5.81761 0.693216 5.75919 0.677195 5.69497C0.661175 5.63076 0.663511 5.56333 0.683939 5.50038C0.704367 5.43743 0.742065 5.38148 0.792738 5.33891C0.843411 5.29634 0.905022 5.26885 0.970553 5.25959L4.41389 4.75625C4.64072 4.72325 4.85615 4.63563 5.04161 4.50091C5.22707 4.3662 5.37702 4.18844 5.47855 3.98292L7.01789 0.863588Z" stroke="#D1D5DC" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

function renderStarsDisplay(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += i <= Math.round(rating) ? STAR_FILLED : STAR_EMPTY;
    }
    return stars;
}

function renderStarsEdit(rating, reviewId) {
    let html = '';
    for (let i = 1; i <= 5; i++) {
        html += `<span class="star-edit ${i <= rating ? 'filled' : ''}" data-value="${i}" data-review="${reviewId}">
            ${i <= rating ? STAR_FILLED : STAR_EMPTY}
        </span>`;
    }
    return html;
}

// ── Load reviews ──
async function loadReviews() {
    const list  = document.getElementById('review-list');
    const count = document.getElementById('review-count');
    list.innerHTML = Array(3).fill(`
        <article class="review-card review-card--skeleton">
            <div style="display:flex;gap:16px;margin-bottom:16px;">
                <div class="skeleton-block" style="width:64px;height:64px;border-radius:10px;flex-shrink:0;"></div>
                <div style="flex:1;display:flex;flex-direction:column;gap:8px;justify-content:center;">
                    <div class="skeleton-block" style="width:60%;height:16px;border-radius:6px;"></div>
                    <div class="skeleton-block" style="width:80px;height:14px;border-radius:6px;"></div>
                </div>
            </div>
            <div class="skeleton-block" style="width:100%;height:56px;border-radius:8px;margin-bottom:16px;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div class="skeleton-block" style="width:100px;height:12px;border-radius:6px;"></div>
                <div style="display:flex;gap:8px;">
                    <div class="skeleton-block" style="width:70px;height:28px;border-radius:8px;"></div>
                    <div class="skeleton-block" style="width:70px;height:28px;border-radius:8px;"></div>
                </div>
            </div>
        </article>`).join('');

    try {
        const res  = await fetch('/api/mijn-reviews');
        const data = await res.json();

        if (!data.success || !data.data.length) {
            count.textContent = '0 reviews geplaatst';
            list.innerHTML = '<p style="color:var(--rustic-taupe)">U heeft nog geen reviews geplaatst.</p>';
            return;
        }

        count.textContent = `${data.data.length} review${data.data.length !== 1 ? 's' : ''} geplaatst`;
        list.innerHTML = '';

        data.data.forEach(r => {
            const date = new Date(r.created_at).toLocaleDateString('nl-NL', {
                day: 'numeric', month: 'long', year: 'numeric'
            });

            const article = document.createElement('article');
            article.className = 'review-card';
            article.dataset.id = r.id;

            article.innerHTML = `
                <div class="review-product">
                    <div class="review-product__image">
                        <img src="/uploads/products/${r.product_image || ''}" alt="${r.product_name}"
                             onerror="this.src=''">
                    </div>
                    <div class="review-product__info">
                        <h3>${r.product_name || '—'}</h3>
                        <div class="review-meta">
                            <span class="stars">${renderStarsDisplay(r.rating)}</span>
                            <span class="score">${r.rating}/5</span>
                        </div>
                    </div>
                </div>

                <div class="review-content" id="view-${r.id}">
                    <p>${r.review}</p>
                </div>

                <div class="review-edit" id="edit-${r.id}" style="display:none;">
                    <div class="edit-stars" id="stars-${r.id}">
                        ${renderStarsEdit(r.rating, r.id)}
                    </div>
                    <textarea class="edit-textarea" id="text-${r.id}">${r.review}</textarea>
                </div>

                <div class="review-footer">
                    <span>${date}</span>
                    <div class="review-actions">
                        <button class="btn-edit" data-id="${r.id}" data-rating="${r.rating}">Bewerken</button>
                        <button class="btn-save" data-id="${r.id}" style="display:none;">Opslaan</button>
                        <button class="btn-cancel" data-id="${r.id}" style="display:none;">Annuleren</button>
                        <button class="btn-delete" data-id="${r.id}">Verwijderen</button>
                    </div>
                </div>
            `;

            list.appendChild(article);
        });

        attachEvents();

    } catch (err) {
        console.error(err);
        toast('Kon reviews niet laden', 'error');
    }
}

function attachEvents() {
    // edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById(`view-${id}`).style.display = 'none';
            document.getElementById(`edit-${id}`).style.display = 'block';
            btn.style.display = 'none';
            document.querySelector(`.btn-save[data-id="${id}"]`).style.display = '';
            document.querySelector(`.btn-cancel[data-id="${id}"]`).style.display = '';
        });
    });

    // cancel
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById(`view-${id}`).style.display = 'block';
            document.getElementById(`edit-${id}`).style.display = 'none';
            btn.style.display = 'none';
            document.querySelector(`.btn-save[data-id="${id}"]`).style.display = 'none';
            document.querySelector(`.btn-edit[data-id="${id}"]`).style.display = '';
        });
    });

    // star click
    document.querySelectorAll('.star-edit').forEach(star => {
        star.addEventListener('click', () => {
            const val      = parseInt(star.dataset.value);
            const reviewId = star.dataset.review;
            document.querySelectorAll(`.star-edit[data-review="${reviewId}"]`).forEach((s, i) => {
                const filled = i < val;
                s.classList.toggle('filled', filled);
                s.innerHTML = filled ? STAR_FILLED : STAR_EMPTY;
            });
        });
    });

    // save
    document.querySelectorAll('.btn-save').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id      = btn.dataset.id;
            const stars   = document.querySelectorAll(`.star-edit[data-review="${id}"]`);
            const rating  = [...stars].filter(s => s.classList.contains('filled')).length;
            const review  = document.getElementById(`text-${id}`).value.trim();

            if (!rating || !review) { toast('Vul alle velden in', 'error'); return; }

            const res  = await fetch('/api/mijn-reviews/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, rating, review })
            });
            const data = await res.json();

            if (data.success) {
                toast('Review bijgewerkt');
                loadReviews();
            } else {
                toast(data.message || 'Bijwerken mislukt', 'error');
            }
        });
    });

    // delete
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Weet u zeker dat u deze review wilt verwijderen?')) return;

            const res  = await fetch('/api/mijn-reviews/delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: btn.dataset.id })
            });
            const data = await res.json();

            if (data.success) {
                toast('Review verwijderd');
                loadReviews();
            } else {
                toast(data.message || 'Verwijderen mislukt', 'error');
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', loadReviews);