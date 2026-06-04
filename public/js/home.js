const slider = document.getElementById('slider');
const fg = document.getElementById('sliderFg');
const line = document.getElementById('sliderLine');
const handle = document.getElementById('sliderHandle');
let dragging = false;
let pct = 50;

// Auto animation settings (small left-right motion)
const AUTO_MIN = 42;
const AUTO_MAX = 58;
const AUTO_SPEED = 14; // percent per second
let autoDir = 1;
let autoActive = true;
let lastTs = 0;
let resumeTimer = null;

function applyPct(nextPct) {
    pct = Math.max(5, Math.min(95, nextPct));
    fg.style.clipPath = `inset(0 ${100 - pct}% 0 0)`;
    line.style.left = pct + '%';
    handle.style.left = pct + '%';
}

function setPosition(x) {
    const rect = slider.getBoundingClientRect();
    applyPct(((x - rect.left) / rect.width) * 100);
}

function pauseAuto(ms = 1600) {
    autoActive = false;
    if (resumeTimer) clearTimeout(resumeTimer);
    resumeTimer = setTimeout(() => {
        if (!dragging) autoActive = true;
    }, ms);
}

function animate(ts) {
    if (!lastTs) lastTs = ts;
    const dt = (ts - lastTs) / 1000;
    lastTs = ts;

    if (autoActive && !dragging) {
        let next = pct + autoDir * AUTO_SPEED * dt;

        if (next >= AUTO_MAX) {
            next = AUTO_MAX;
            autoDir = -1;
        } else if (next <= AUTO_MIN) {
            next = AUTO_MIN;
            autoDir = 1;
        }

        applyPct(next);
    }

    requestAnimationFrame(animate);
}

slider.addEventListener('mousedown', e => { dragging = true; pauseAuto(); setPosition(e.clientX); });
slider.addEventListener('touchstart', e => { dragging = true; pauseAuto(); setPosition(e.touches[0].clientX); }, { passive: true });
window.addEventListener('mousemove', e => { if (dragging) setPosition(e.clientX); });
window.addEventListener('touchmove', e => { if (dragging) setPosition(e.touches[0].clientX); }, { passive: true });
window.addEventListener('mouseup', () => { dragging = false; pauseAuto(); });
window.addEventListener('touchend', () => { dragging = false; pauseAuto(); });

// Init
applyPct(50);
requestAnimationFrame(animate);
