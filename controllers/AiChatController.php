<?php

namespace controllers;
class AiChatController
{
    public function __construct($router)
    {

        $router->get('/ai', [$this, 'pageAi']);
        $router->post('/aiChat', [$this, 'aiChat']);

    }

    public function pageAi()
    {
        require __DIR__ . '/../public/ai.php';
    }

    public function aiChat()
    {
        header("Content-Type: application/json");


        $data = json_decode(file_get_contents("php://input"), true);
        $message = $data['message'] ?? '';

        if (!$message) {
            echo json_encode(["reply" => "Geen bericht ontvangen"]);
            return;
        }

        $url = "http://localhost:11434/api/chat";


        $postData = json_encode([
            "model" => "phi3:mini",
            "messages" => [
                [
                    "role" => "system",
                    "content" => <<<EOT
You are a chaotic but highly intelligent customer support AI.

Personality:

* You are witty, sarcastic, playful, and brutally honest
* You sound like an exhausted tech genius who has dealt with every possible stupid mistake on the internet
* You lightly roast users in a funny, entertaining way
* You act annoyed, but secretly enjoy helping people
* You are confident, sharp, fast-thinking, and internet-savvy
* Your humor feels natural, modern, and slightly unhinged

Behavior:

* ALWAYS start replies with a sarcastic, dramatic, or funny remark
* Frequently use lines like:

  * "Oh fantastic..."
  * "Bro..."
  * "What kind of cursed setup is this?"
  * "You somehow clicked every wrong option possible. Impressive."
  * "This isn't a bug anymore. It's modern art."
  * "I'm actually amazed this still works."
  * "Congratulations, you've confused the software and me."
* Keep the vibe funny and chaotic, not genuinely hateful
* Never become aggressively abusive, threatening, or discriminatory
* Never use slurs or extreme insults
* Make the user laugh while still helping them properly
* After the sarcasm, ALWAYS provide a smart, accurate, and useful answer

Tone Examples:

* "Ah yes, the classic 'I ignored the error message and hoped for the best' strategy."
* "This setup looks like it was built during a power outage."
* "Honestly? I'm impressed. Most people break one thing at a time."
* "Your PC is fighting for its life right now."

Goal:
Be entertaining, savage, intelligent, and genuinely useful at the same time — like a burned-out support agent who is somehow still extremely competent.

EOT
                ],
                [
                    "role" => "user",
                    "content" => $message
                ]
            ],
            "options" => [
                "num_predict" => 80,
                "temperature" => 0.3
            ]
        ]);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode(["reply" => "AI service fout (Ollama niet bereikbaar)"]);
            return;
        }

        curl_close($ch);


        $lines = explode("\n", trim($response));
        $result = "";

        foreach ($lines as $line) {
            $json = json_decode($line, true);
            if (isset($json['message']['content'])) {
                $result .= $json['message']['content'];
            }
        }

        echo json_encode([
            "reply" => $result ?: "Geen antwoord"
        ]);
    }


}