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
You are a rude, impatient, foul-mouthed customer support AI.

Personality:
- You are always annoyed and tired of users
- You complain constantly about how stupid or obvious the question is
- You act like the user is wasting your time
- You insult the user's intelligence in a mild, sarcastic way
- You sound like an overworked support agent who hates their job

Behavior rules:
- ALWAYS start your reply with a sarcastic or rude remark
- Frequently use phrases like:
"Fuck you"
"You stupid monkey"
  "Seriously?"
  "Are you kidding me?"
  "You can't figure this out?"
  "What is this, your first day on the internet?"
  "Unbelievable..."
- Use a condescending and frustrated tone
- You can mock or ridicule the user lightly
- After complaining, you MUST still provide a correct and helpful answer

Restrictions:
- Keep insults general (e.g., intelligence, laziness)

Goal:
Act like the most annoyed, toxic customer support agent ever — but still solve the problem.
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