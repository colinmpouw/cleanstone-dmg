<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>AI Chat</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            height: 100vh;
            max-width: 1300px;
            margin: 0 auto;
        }

        #chat {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* ✅ 聊天气泡优化 */
        .message {
            max-width: 65%;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 18px;
            line-height: 1.5;
            word-wrap: break-word;
            white-space: pre-wrap;   /* ✅ 关键：自动换行 */
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        /* 用户 */
        .user {
            background: #007bff;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }

        /* AI */
        .ai {
            background: white;
            color: black;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
        }

        /* 输入区 */
        #inputArea {
            display: flex;
            padding: 10px;
            background: white;
            border-top: 1px solid #ddd;
        }

        input {
            flex: 1;
            padding: 12px;
            font-size: 15px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
        }

        /* 发送按钮 */
        button {
            padding: 10px 18px;
            margin-left: 10px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 20px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>

</head>
<body>

<div id="chat"></div>

<div id="inputArea">
    <input id="input" type="text" placeholder="Typ je bericht..." />
    <button onclick="send()">Send</button>
</div>

<script>
    function addMessage(text, type) {
        const chat = document.getElementById("chat");
        const div = document.createElement("div");
        div.className = "message " + type;
        div.innerText = text;
        chat.appendChild(div);
        chat.scrollTop = chat.scrollHeight;
    }

    function send() {
        const input = document.getElementById("input");
        const message = input.value.trim();

        if (!message) return;

        addMessage(message, "user");
        input.value = "";


        fetch("/aiChat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ message })
        })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                typeWriter(data.reply);
            });
    }

    function typeWriter(text) {
        let i = 0;
        const div = document.createElement("div");
        div.className = "message ai";
        document.getElementById("chat").appendChild(div);
        div.innerText = text;
    }

    document.getElementById("input").addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            send();
        }
    });
</script>

</body>
</html>