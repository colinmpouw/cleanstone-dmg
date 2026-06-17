<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin -Advies</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminAdvice.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

<div class="aanvragen-page">

    <!-- PAGE HEADER -->
    <div class="aanvragen-page__header">
        <h1>Adviesaanvragen</h1>
        <p>2 nieuwe aanvragen wachten op beantwoording</p>
    </div>

    <!-- TABS -->
    <div class="aanvragen-tabs">
        <button class="aanvragen-tab active">Alle <span>4</span></button>
        <button class="aanvragen-tab">Nieuw <span>2</span></button>
        <button class="aanvragen-tab">In behandeling <span>1</span></button>
        <button class="aanvragen-tab">Beantwoord <span>1</span></button>
    </div>

    <!-- GRID -->
    <div class="aanvragen-grid">

        <!-- Karin Meijer — Nieuw -->
        <div class="aanvraag-card">
            <img class="aanvraag-card__img" src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80" alt="foto">
            <div class="aanvraag-card__body">
                <div class="aanvraag-card__top">
                    <div>
                        <div class="aanvraag-card__name">Karin Meijer</div>
                        <div class="aanvraag-card__sub">Travertin terras</div>
                    </div>
                    <span class="aanvraag-badge aanvraag-badge--nieuw">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                Nieuw
                            </span>
                </div>
                <p class="aanvraag-card__desc">Witte kalkafzetting op de stenen, met name na regen. Al meerdere keren geprobeerd te reinigen maar het blijft</p>
                <div class="aanvraag-card__footer">
                    <span class="aanvraag-card__date">14 jun 2025</span>
                    <a href="/admin/advieschat" class="aanvraag-card__btn aanvraag-card__btn--primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Beantwoord
                    </a>
                </div>
            </div>
        </div>

        <!-- Rob Hendriksen — In behandeling -->
        <div class="aanvraag-card">
            <img class="aanvraag-card__img" src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="foto">
            <div class="aanvraag-card__body">
                <div class="aanvraag-card__top">
                    <div>
                        <div class="aanvraag-card__name">Rob Hendriksen</div>
                        <div class="aanvraag-card__sub">Blauwe hardsteen keuken</div>
                    </div>
                    <span class="aanvraag-badge aanvraag-badge--behandeling">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                In behandeling
                            </span>
                </div>
                <p class="aanvraag-card__desc">Olievlekken na het koken die niet meer weggaan. Het aanrecht heeft een lichte etssteen beschadiging.</p>
                <div class="aanvraag-card__footer">
                    <span class="aanvraag-card__date">13 jun 2025</span>
                    <a href="/admin/advieschat" class="aanvraag-card__btn aanvraag-card__btn--outline">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Bekijk
                    </a>
                </div>
            </div>
        </div>

        <!-- Anna van Dam — Beantwoord -->
        <div class="aanvraag-card">
            <div class="aanvraag-card__no-img">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div class="aanvraag-card__body">
                <div class="aanvraag-card__top">
                    <div>
                        <div class="aanvraag-card__name">Anna van Dam</div>
                        <div class="aanvraag-card__sub">Marmeren vloer</div>
                    </div>
                    <span class="aanvraag-badge aanvraag-badge--beantwoord">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Beantwoord
                            </span>
                </div>
                <p class="aanvraag-card__desc">Dof geworden na gebruik van de verkeerde reiniger. Wil graag de glans terugbrengen.</p>
                <div class="aanvraag-card__footer">
                    <span class="aanvraag-card__date">12 jun 2025</span>
                    <a href="/admin/advieschat" class="aanvraag-card__btn aanvraag-card__btn--outline">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Bekijk
                    </a>
                </div>
            </div>
        </div>

        <!-- Dirk Willems — Nieuw -->
        <div class="aanvraag-card">
            <img class="aanvraag-card__img" src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="foto">
            <div class="aanvraag-card__body">
                <div class="aanvraag-card__top">
                    <div>
                        <div class="aanvraag-card__name">Dirk Willems</div>
                        <div class="aanvraag-card__sub">Graniet aanrecht</div>
                    </div>
                    <span class="aanvraag-badge aanvraag-badge--nieuw">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                Nieuw
                            </span>
                </div>
                <p class="aanvraag-card__desc">Zwarte vlekken die lijken op schimmel tussen de stenen. Ik maak de keuken dagelijks schoon.</p>
                <div class="aanvraag-card__footer">
                    <span class="aanvraag-card__date">11 jun 2025</span>
                    <a href="/admin/advieschat" class="aanvraag-card__btn aanvraag-card__btn--primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Beantwoord
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.aanvragen-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.aanvragen-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });
</script>
</div>

</body>
</html>