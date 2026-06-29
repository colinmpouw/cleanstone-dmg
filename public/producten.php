<?php
if (!isset($products, $categories, $brands)) {
    require_once __DIR__ . '/../autoloader.php';
    require_once __DIR__ . '/../controllers/DatabaseController.php';
    $db = new controllers\DatabaseController();
    $categories = $db->read("SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name") ?: [];
    $brands = $db->read("SELECT id, name FROM brands ORDER BY name") ?: [];
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cleanstone -Producten</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/producten.css">
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
</head>
<body>
<?php include __DIR__ . '/../component/header.php'; ?>

<main class="products-page">

    <div class="page-title">
        <h1>Alle Producten</h1>
        <p>Premium onderhoudsmiddelen voor natuursteen van de beste merken</p>
    </div>

    <div class="container products-layout">

        <!-- ── DESKTOP SIDEBAR ── -->
        <aside class="filters">
            <div class="filters-header">
                <h3>Filters</h3>
                <button class="filters-clear" id="clear-filters">Wis alles</button>
            </div>

            <div class="filter-group">
                <label>Zoeken</label>
                <input id="product-search" type="search" placeholder="Zoek producten...">
            </div>

            <div class="filter-group">
                <label>Categorie</label>
                <ul>
                    <li><a class="active" href="#" data-category="all">Alle categorieën</a></li>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="#" data-category="<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="filter-group">
                <label>Merk</label>
                <ul>
                    <li><a class="active" href="#" data-brand="all">Alle merken</a></li>
                    <?php foreach ($brands as $brand): ?>
                        <li><a href="#" data-brand="<?= htmlspecialchars($brand['name']) ?>"><?= htmlspecialchars($brand['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <!-- ── GRID WRAPPER ── -->
        <div class="products-grid-wrapper">

            <div class="products-grid-topbar">
                <p id="product-count">Laden...</p>

                <!-- Filter toggle — mobile only -->
                <button class="filter-toggle-btn" id="filter-toggle-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                        <line x1="11" y1="18" x2="13" y2="18"/>
                    </svg>
                    Filters
                </button>
            </div>

            <section id="products-grid" class="products-grid"></section>
        </div>
    </div>

</main>

<!-- ── MOBILE FILTER OVERLAY ── -->
<div class="filter-overlay" id="filter-overlay"></div>

<!-- ── MOBILE FILTER DRAWER ── -->
<div class="filter-drawer" id="filter-drawer">
    <div class="filter-drawer-handle"></div>

    <div class="filter-drawer-header">
        <h3>Filters</h3>
        <button class="filter-drawer-close" id="filter-drawer-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="filter-group">
        <label>Zoeken</label>
        <input id="product-search-mobile" type="search" placeholder="Zoek producten...">
    </div>

    <div class="filter-group">
        <label>Categorie</label>
        <ul>
            <li><a class="active" href="#" data-category="all">Alle categorieën</a></li>
            <?php foreach ($categories as $cat): ?>
                <li><a href="#" data-category="<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="filter-group">
        <label>Merk</label>
        <ul>
            <li><a class="active" href="#" data-brand="all">Alle merken</a></li>
            <?php foreach ($brands as $brand): ?>
                <li><a href="#" data-brand="<?= htmlspecialchars($brand['name']) ?>"><?= htmlspecialchars($brand['name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <button class="filter-apply-btn" id="filter-apply-btn">Filters toepassen</button>
</div>

<script>
    // ── MOBILE DRAWER ──
    const toggleBtn   = document.getElementById('filter-toggle-btn');
    const drawer      = document.getElementById('filter-drawer');
    const overlay     = document.getElementById('filter-overlay');
    const closeBtn    = document.getElementById('filter-drawer-close');
    const applyBtn    = document.getElementById('filter-apply-btn');

    function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
    if (closeBtn)  closeBtn.addEventListener('click', closeDrawer);
    if (overlay)   overlay.addEventListener('click', closeDrawer);
    if (applyBtn)  applyBtn.addEventListener('click', closeDrawer);
</script>

<?php require_once __DIR__ . '/../component/aiChat.php'; ?>
<?php include __DIR__ . '/../component/footer.php'; ?>
<script src="/public/js/AiChat.js"></script>
<script src="/public/js/producten.js"></script>
</body>
</html>