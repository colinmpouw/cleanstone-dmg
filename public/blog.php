<!doctype html>
<html lang="nl">
<?php
$blogThemes = array_merge(['Alles'], $blogThemes ?? []);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/blog.css">
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <title>CleanStone -Blog</title>
</head>

<body class="blog">
    <?php
    require_once __DIR__ . '/../component/header.php';
    ?>

    <main class="blog-page">
        <section class="blog-hero">
            <div class="container">
                <h1>Blog &amp; Advies</h1>
                <p class="lead">Tips, tricks en advies voor optimaal natuursteen onderhoud</p>

                <div class="filters">
                    <?php foreach ($blogThemes as $index => $theme): ?>
                        <button class="pill <?php echo $index === 0 ? 'active' : ''; ?>" type="button" data-filter="<?php echo htmlspecialchars($theme, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($theme); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="posts container">
            <h2 class="section-title">Nieuwste artikelen</h2>
            <div class="card-grid">
                <?php foreach (($blogs ?? []) as $item): ?>
                    <article class="post-card" data-themes="<?php echo htmlspecialchars($item['tag_keys'] ?? $item['tag'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="media">
                            <img src="<?php echo htmlspecialchars($item['image'] ?? '/public/assets/schone_tegel.png'); ?>"
                                alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <span class="cat"><?php echo htmlspecialchars($item['tag']); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="meta">
                                <span class="date"><?php echo date('d F Y', strtotime($item['date'])); ?></span>
                                <span class="readtime">5 min</span>
                            </div>
                            <h3 class="post-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="excerpt">
                                <?php echo htmlspecialchars($item['excerpt'] ?? (function_exists('mb_strimwidth') ? mb_strimwidth($item['article'], 0, 110, '…') : substr($item['article'], 0, 110) . '…')); ?>
                            </p>
                            <div class="card-footer">
                                <span class="author">Door <?php echo htmlspecialchars($item['arthor']); ?></span>
                                <a class="read-more" href="/blog/<?php echo (int) $item['blog_id']; ?>">Lees meer →</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <p class="no-posts" hidden>Geen artikelen gevonden voor dit thema.</p>
        </section>

        <section class="subscribe alt">
            <div class="container">
                <div class="subscribe-inner">
                    <h2>Blijf op de hoogte</h2>
                    <h2>Schrijf je in voor onderhoudstips</h2>
                    <p>Krijg praktische tips en aanbiedingen direct in je mailbox.</p>
                    <form class="subscribe-form" action="#" method="post">
                        <input type="email" name="email" placeholder="E-mailadres">
                        <button type="submit" class="btn-outline">Aanmelden</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/../component/footer.php';
    ?>
    <?php require_once __DIR__ . '/../component/aiChat.php'; ?>
    <script src="/public/js/AiChat.js"></script>
    <script src="/public/js/home.js"></script>
    <script src="/public/js/blog.js"></script>
</body>

</html>
