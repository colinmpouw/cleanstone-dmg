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

        <!-- MESSAGES -->
        <div class="chat-messages" id="chatMessages">

            </div>

        </div>

        <!-- INPUT -->
        <div class="chat-input-area">
            <div class="chat-input-row">
                <button class="attach-btn" title="Bijlage toevoegen">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                </button>
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