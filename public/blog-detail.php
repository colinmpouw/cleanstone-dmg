<!doctype html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/blog.css">
    <title><?php echo htmlspecialchars($blog['title']); ?> · CleanStone</title>
</head>

<body class="blog blog-detail">
    <?php require_once __DIR__ . '/../component/header.php'; ?>

    <main class="blog-page blog-detail-page">
        <section class="blog-hero">
            <div class="container">
                <p class="eyebrow">Blog &amp; Advies</p>
                <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
                <p class="lead">Door <?php echo htmlspecialchars($blog['arthor']); ?> ·
                    <?php echo date('d F Y', strtotime($blog['date'])); ?> · Tag:
                    <?php echo htmlspecialchars($blog['tag']); ?>
                </p>
            </div>
        </section>

        <section class="detail-hero container">
            <div class="detail-card">
                <div class="detail-image">
                    <img src="<?php echo htmlspecialchars($blog['image'] ?? '/public/assets/schone_tegel.png'); ?>"
                        alt="<?php echo htmlspecialchars($blog['title']); ?>">
                </div>
                <div class="detail-grid">
                    <article class="detail-main">
                        <h2>Artikel</h2>
                        <p><?php echo nl2br(htmlspecialchars($blog['article'])); ?></p>

                        <div class="detail-summary">
                            <h3>Samenvatting</h3>
                            <p>Dit artikel hoort bij de tag
                                <strong><?php echo htmlspecialchars($blog['tag']); ?></strong> en is geschreven door
                                <?php echo htmlspecialchars($blog['arthor']); ?>.
                            </p>
                        </div>

                        <h3>Wat je hieruit haalt</h3>
                        <ul class="detail-list">
                            <li>Praktische uitleg bij het onderwerp van dit blogartikel.</li>
                            <li>De belangrijkste metadata uit de database, zoals auteur, datum en tag.</li>
                            <li>Gerelateerde artikelen die op dezelfde tag zijn gebaseerd.</li>
                        </ul>
                    </article>

                    <aside class="detail-aside">
                        <div class="entity-card">
                            <h3>Entity Details</h3>
                            <div class="entity-row">
                                <span>ID</span><strong><?php echo (int) $blog['blog_id']; ?></strong>
                            </div>
                            <div class="entity-row">
                                <span>Auteur</span><strong><?php echo htmlspecialchars($blog['arthor']); ?></strong>
                            </div>
                            <div class="entity-row">
                                <span>Tag</span><strong><?php echo htmlspecialchars($blog['tag']); ?></strong>
                            </div>
                            <div class="entity-row">
                                <span>Datum</span><strong><?php echo date('d-m-Y', strtotime($blog['date'])); ?></strong>
                            </div>
                        </div>

                        <div class="entity-card muted">
                            <h3>Snelle info</h3>
                            <p>Deze pagina is bedoeld als detailweergave voor één blogpost, zodat de knop “Lees meer”
                                een echte inhoudelijke pagina opent.</p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="related-entities container">
            <h2>Gerelateerde onderdelen</h2>
            <?php if (!empty($relatedBlogs)): ?>
                <div class="entity-grid">
                    <?php foreach ($relatedBlogs as $related): ?>
                        <a class="entity-chip entity-chip-link"
                            href="/blog/<?php echo (int) $related['blog_id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="entity-grid">
                    <div class="entity-chip">Nog geen gerelateerde artikelen gevonden</div>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php require_once __DIR__ . '/../component/footer.php'; ?>
</body>

</html>