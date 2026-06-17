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

            <div class="date-divider"><span>14 jun 2025</span></div>

            <!-- klant: foto -->
            <div class="msg-group">
                <div class="msg-avatar msg-avatar--km">KM</div>
                <div class="msg-bubbles">
                    <div class="msg-image">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=560&q=80" alt="Foto klant">
                    </div>
                    <span class="msg-meta">Karin Meijer · 10:14</span>
                </div>
            </div>

            <!-- klant: bericht 1 -->
            <div class="msg-group">
                <div class="msg-avatar msg-avatar--km">KM</div>
                <div class="msg-bubbles">
                    <div class="msg-bubble">Hallo! Ik heb witte kalkafzetting op mijn travertin terras. Na elke regenbui komt het terug. Ik heb al verschillende reinigingsmiddelen geprobeerd maar niets helpt.</div>
                    <span class="msg-meta">Karin Meijer · 10:14</span>
                </div>
            </div>

            <!-- klant: bericht 2 -->
            <div class="msg-group">
                <div class="msg-avatar msg-avatar--km">KM</div>
                <div class="msg-bubbles">
                    <div class="msg-bubble">Ik heb ook een foto bijgevoegd zodat u kunt zien hoe erg het is.</div>
                    <span class="msg-meta">Karin Meijer · 10:15</span>
                </div>
            </div>

            <!-- admin: reply 1 -->
            <div class="msg-group msg-group--right">
                <div class="msg-bubbles">
                    <div class="msg-bubble">hi</div>
                    <span class="msg-meta">CleanStone · 09:08</span>
                </div>
                <div class="msg-avatar msg-avatar--cs">CS</div>
            </div>

            <!-- admin: reply 2 -->
            <div class="msg-group msg-group--right">
                <div class="msg-bubbles">
                    <div class="msg-bubble">im very good at my job u bil</div>
                    <span class="msg-meta">CleanStone · 09:09</span>
                </div>
                <div class="msg-avatar msg-avatar--cs">CS</div>
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

<script>
    const input = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');
    const messages = document.getElementById('chatMessages');

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;
        const now = new Date();
        const time = now.getHours() + ':' + String(now.getMinutes()).padStart(2,'0');
        const group = document.createElement('div');
        group.className = 'msg-group msg-group--right';
        group.innerHTML = `
      <div class="msg-bubbles">
        <div class="msg-bubble">${text}</div>
        <span class="msg-meta">CleanStone · ${time}</span>
      </div>
      <div class="msg-avatar msg-avatar--cs">CS</div>`;
        messages.appendChild(group);
        input.value = '';
        input.style.height = '40px';
        messages.scrollTop = messages.scrollHeight;
    }

    sendBtn.addEventListener('click', sendMessage);

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    input.addEventListener('input', () => {
        input.style.height = '40px';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });
</html>