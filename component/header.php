<?php
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/');
$currentPath = $currentPath === '' ? '/' : $currentPath;
?>
<?php $currentUser = $_SESSION['user'] ?? null; ?>
<header>
    <nav>
        <div class="left">
            <div class="logo">
                <a href="/home" aria-label="Home">
                    <img src="/public/assets/logo-cleanstone.png" alt="Cleanstone">
                </a>
            </div>
            <button class="search-btn" aria-label="Zoeken">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </div>

        <ul>
            <li><a href="/home">HOME</a></li>
            <li><a href="/producten">PRODUCTEN</a></li>
            <li><a href="/bundels">BUNDELS</a></li>
            <li><a href="/advies">ADVIES</a></li>
            <li><a href="/overons">OVER ONS</a></li>
            <li><a href="/blog">BLOG</a></li>
        </ul>

        <div class="right">
            <div class="divider"></div>
            <a class="icon-btn" href="<?php echo $currentUser ? '/account' : '/login'; ?>" aria-label="Account">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
            </a>
            <button class="icon-btn cart" aria-label="Winkelwagen">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="20" r="1.4"/>
                    <circle cx="18" cy="20" r="1.4"/>
                    <path d="M2 3h3l2.6 13h11l2-9H6"/>
                </svg>
                <span class="badge">0</span>
            </button>
        </div>
    </nav>
</header>

<script>
(() => {
    const links = document.querySelectorAll('nav ul a[href]');
    const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

    const normalize = (href) => {
        const path = new URL(href, window.location.origin).pathname.replace(/\/+$/, '') || '/';
        return path;
    };

    links.forEach(link => {
        const isActive = normalize(link.getAttribute('href')) === currentPath;
        link.classList.toggle('active', isActive);

        link.addEventListener('click', () => {
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        });
    });
})();
</script>
