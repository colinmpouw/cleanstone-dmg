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
    <link rel="stylesheet" href="/admin/css/adminAdviceChat.css">

</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="page-content">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>
    <div class="chat-card">

        <div class="chat-header">
            <button class="chat-header__back" onclick="history.back()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="chat-header__avatar">KM</div>
            <div class="chat-header__info">
                <h3>Karin Meijer</h3>
                <span>Travertin terras · karin@example.com</span>
            </div>
            <span class="status-pill">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        In behandeling
      </span>
        </div>

        <!-- SUBMITTED IMAGES STRIP -->
        <div class="adv-images-strip" id="advImagesStrip" style="display:none">
            <span class="adv-images-strip__label">Bijgevoegde foto's</span>
            <div class="adv-images-strip__grid" id="advImagesGrid"></div>
        </div>

        <!-- MESSAGES -->
        <div class="chat-messages" id="chatMessages">

            </div>

        </div>

        <!-- INPUT -->
        <div class="chat-input-area">
            <div class="chat-input-row">
                <label class="attach-btn" title="Foto uploaden">
                    <input type="file" id="chatImageInput" accept="image/*" style="display:none">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </label>
                <textarea class="chat-input" id="chatInput" placeholder="Schrijf een bericht..."></textarea>
                <button class="send-btn" id="sendBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
            <span class="chat-hint">Enter om te verzenden · Shift+Enter voor nieuwe regel</span>
        </div>

    </div>
</div>

<script src="/admin/js/adminAdviceChat.js"></script>

</html>