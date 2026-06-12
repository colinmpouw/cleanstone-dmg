const chat = document.getElementById("AiChat-messages");
const container = document.getElementById("AiChat-container");
const input = document.getElementById("AiChat-input");
const sendBtn = document.getElementById("AiChat-send-button");

// ── Toggle ────────────────────────────────────────────────
document.getElementById("AiChat-button").addEventListener("click", () => {
    const isHidden = container.style.display === "none" || container.style.display === "";
    container.style.display = isHidden ? "flex" : "none";
    if (isHidden) input.focus();
});

document.getElementById("AiChat-close-button").addEventListener("click", () => {
    container.style.display = "none";
});

// ── Messages ──────────────────────────────────────────────
function addMessage(text, type) {
    const div = document.createElement("div");
    div.className = "msg " + type;
    div.innerText = text;
    chat.appendChild(div);
    chat.scrollTop = chat.scrollHeight;
}

function showTyping() {
    const el = document.createElement("div");
    el.className = "typing-indicator";
    el.id = "AiChat-typing";
    el.innerHTML = "<span></span><span></span><span></span>";
    chat.appendChild(el);
    chat.scrollTop = chat.scrollHeight;
}

function removeTyping() {
    document.getElementById("AiChat-typing")?.remove();
}

function typeWriter(text) {
    removeTyping();
    const div = document.createElement("div");
    div.className = "msg ai";
    chat.appendChild(div);

    let i = 0;
    const interval = setInterval(() => {
        div.innerText = text.slice(0, ++i);
        chat.scrollTop = chat.scrollHeight;
        if (i >= text.length) clearInterval(interval);
    }, 18);
}

// ── Send ──────────────────────────────────────────────────
function send() {
    const message = input.value.trim();
    if (!message) return;

    addMessage(message, "user");
    input.value = "";
    sendBtn.disabled = true;
    showTyping();

    fetch("/aiChat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message })
    })
        .then(res => res.json())
        .then(data => typeWriter(data.reply))
        .catch(() => {
            removeTyping();
            addMessage("Could not connect. Please try again.", "ai");
        })
        .finally(() => {
            sendBtn.disabled = false;
            input.focus();
        });
}

sendBtn.addEventListener("click", send);
input.addEventListener("keypress", e => { if (e.key === "Enter") send(); });