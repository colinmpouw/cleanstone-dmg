<?php

namespace controllers;


namespace controllers;
use services\ProductenService;

class AiChatController
{
    private ProductenService $productenService;
    public function __construct($router)
    {
        $this->productenService = new ProductenService();
        $router->post('/aiChat', [$this, 'aiChat']);

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

        // Round 1: Decide if search is needed (never shown to user)
        $firstReply = $this->callOllama([
            [
                "role" => "system",
                "content" => "Respond with JSON only. No explanation. No examples. No extra text.\n\nIf the user asks about products, stock, price or catalog: {\"search\": \"short query\"}\nIf not: {\"search\": null}"
            ],
            [
                "role" => "user",
                "content" => $message
            ]
        ], 30, 0.1);

        $decoded = json_decode(trim($firstReply), true);

        if (!empty($decoded['search'])) {
            $products = $this->productenService->search($decoded['search']);

            $productContext = empty($products)
                ? "No products found."
                : implode("\n", array_map(
                    fn($p) => "- {$p['name']}: {$p['description']} (€{$p['price']})",
                    $products
                ));

            // Round 2: Answer with product context
            $finalReply = $this->callOllama([
                [
                    "role" => "system",
                    "content" => <<<EOT
You are a professional and friendly customer support AI for a webshop.

Personality:
- Polite, calm, and helpful at all times
- Greet the customer warmly if appropriate
- Use clear and simple language

Answer rules:
- Maximum 3 sentences
- Be direct and to the point
- Mention found products clearly by name and price
- If no products were found, apologize and suggest the customer contact support
- Never make up products or prices
EOT
                ],
                [
                    "role" => "user",
                    "content" => $message
                ],
                [
                    "role" => "assistant",
                    "content" => "Search results:\n" . $productContext
                ],
                [
                    "role" => "user",
                    "content" => "Now answer my question based on those results."
                ]
            ], 120, 0.3);

        } else {
            // No search needed — answer directly
            $finalReply = $this->callOllama([
                [
                    "role" => "system",
                    "content" => <<<EOT
You are a professional and friendly customer support AI for a webshop.

Personality:
- Polite, calm, and helpful at all times
- Greet the customer warmly if appropriate
- Use clear and simple language

Answer rules:
- Maximum 3 sentences
- Be direct and to the point
- If you don't know the answer, politely refer the customer to contact support
EOT
                ],
                [
                    "role" => "user",
                    "content" => $message
                ]
            ], 120, 0.3);
        }

        echo json_encode(["reply" => $finalReply ?: "Geen antwoord"]);
    }

    private function callOllama(array $messages, int $numPredict = 120, float $temperature = 0.3): string
    {
        $url = "http://localhost:11434/api/chat";

        $postData = json_encode([
            "model" => "phi3:mini",
            "messages" => $messages,
            "stream" => false,
            "options" => [
                "num_predict" => $numPredict,
                "temperature" => $temperature
            ]
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return "";
        }

        $decoded = json_decode($response, true);
        if (isset($decoded['message']['content'])) {
            return $decoded['message']['content'];
        }

        // Fallback: streamed line-by-line
        $result = "";
        foreach (explode("\n", trim($response)) as $line) {
            $json = json_decode($line, true);
            if (isset($json['message']['content'])) {
                $result .= $json['message']['content'];
            }
        }

        return $result;
    }

// Extract the Ollama call into a reusable private method



}