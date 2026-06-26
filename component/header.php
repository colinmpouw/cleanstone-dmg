<?php
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/');
$currentPath = $currentPath === '' ? '/' : $currentPath;
$currentUser = $_SESSION['user'] ?? null;
?>

<header>
    <nav>
        <div class="left">
            <div class="logo">
                <a href="/home" aria-label="Home">
                    <img src="/public/assets/logo-cleanstone.png" alt="Cleanstone">
                </a>
            </div>
            <button class="search-btn" aria-label="Zoeken">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </div>

        <!-- Desktop nav -->
        <ul>
            <li><a href="/home">HOME</a></li>
            <li><a href="/producten">PRODUCTEN</a></li>
            <li><a href="/bundels">BUNDELS</a></li>
            <li><a href="/advies">ADVIES</a></li>
            <li><a href="/overons">OVER ONS</a></li>
            <li><a href="/blog">BLOG</a></li>
        </ul>

        <!-- Desktop right -->
        <div class="right">
            <div class="divider"></div>
            <a class="icon-btn" href="<?php echo $currentUser ? '/account' : '/login'; ?>" aria-label="Account">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
            </a>
            <a href="/winkelwagen" class="icon-btn cart" aria-label="Winkelwagen">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="20" r="1.4"/>
                    <circle cx="18" cy="20" r="1.4"/>
                    <path d="M2 3h3l2.6 13h11l2-9H6"/>
                </svg>
                <span class="badge" id="cart-count">0</span>
            </a>
        </div>

        <!-- Hamburger (mobile only) -->
        <button class="hamburger" id="hamburger" aria-label="Menu openen">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</header>

<!-- Mobile menu overlay -->
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true">

    <button class="mobile-close" id="mobile-close" aria-label="Menu sluiten">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    <ul class="mobile-nav">
        <li><a href="/home">HOME</a></li>
        <li><a href="/producten">PRODUCTEN</a></li>
        <li><a href="/bundels">BUNDELS</a></li>
        <li><a href="/advies">ADVIES</a></li>
        <li><a href="/overons">OVER ONS</a></li>
        <li><a href="/blog">BLOG</a></li>
    </ul>

    <div class="mobile-icons">
        <a class="mobile-icon-btn" href="<?php echo $currentUser ? '/account' : '/login'; ?>" aria-label="Account">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
            </svg>
        </a>
        <a href="/winkelwagen" class="mobile-icon-btn" aria-label="Winkelwagen">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="20" r="1.4"/>
                <circle cx="18" cy="20" r="1.4"/>
                <path d="M2 3h3l2.6 13h11l2-9H6"/>
            </svg>
            <span class="badge" id="cart-count-mobile">0</span>
        </a>
    </div>

</div>

<script>
    (() => {
        // ── ACTIVE LINKS ──
        const allLinks = document.querySelectorAll('nav ul a[href], .mobile-nav a[href]');
        const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        const normalize = href => new URL(href, window.location.origin).pathname.replace(/\/+$/, '') || '/';

        allLinks.forEach(link => {
            link.classList.toggle('active', normalize(link.getAttribute('href')) === currentPath);
            link.addEventListener('click', () => {
                allLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            });
        });

        // ── MOBILE MENU ──
        const hamburger  = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeBtn   = document.getElementById('mobile-close');

        function openMenu() {
            mobileMenu.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        }

        hamburger.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);

        // close on link click
        document.querySelectorAll('.mobile-nav a').forEach(a => {
            a.addEventListener('click', closeMenu);
        });

        // close on outside click
        mobileMenu.addEventListener('click', e => {
            if (e.target === mobileMenu) closeMenu();
        });
    })();

    // ── CART COUNT ──
    async function loadCartItemCount() {
        try {
            const response = await fetch('/api/get_all_cart_item');
            const result   = await response.json();
            if (!result.success) return;

            const count = result.data.length;
            document.querySelectorAll('#cart-count, #cart-count-mobile').forEach(el => {
                el.style.display = 'flex';
                el.textContent = count;
            });
        } catch (e) {
            console.error(e);
        }
    }

    document.addEventListener('DOMContentLoaded', loadCartItemCount);
</script>