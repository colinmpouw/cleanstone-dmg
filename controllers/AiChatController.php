<?php

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
        $message = trim($data['message'] ?? '');

        if ($message === '') {
            echo json_encode(["reply" => "Geen bericht ontvangen"]);
            return;
        }

        // Step 1: extract + normalize keyword
        $searchQuery = $this->extractSearchKeyword($message);
        if ($searchQuery) {
            $searchQuery = $this->normalizeKeyword($searchQuery);
        }
        error_log("SEARCH KEYWORD (normalized): " . ($searchQuery ?? 'NULL'));

        // Step 2: fetch products
        $productContext = "";

        if ($searchQuery) {
            $products = $this->productenService->searchProductsForAi($searchQuery);

            if (!empty($products)) {
                $lines = array_map(function ($p) {
                    $price     = "€" . number_format($p['price'], 2, ',', '.');
                    $salePrice = !empty($p['sale_price']) ? " (aanbieding: €" . number_format($p['sale_price'], 2, ',', '.') . ")" : "";
                    $rating    = !empty($p['avg_rating']) ? ", beoordeling: {$p['avg_rating']}/5" : "";
                    $category  = !empty($p['category_name']) ? ", categorie: {$p['category_name']}" : "";
                    $short     = (!empty($p['short_description']) && $p['short_description'] !== '-') ? " – {$p['short_description']}" : "";
                    return "- {$p['name']} | {$price}{$salePrice}{$category}{$rating}{$short}";
                }, $products);

                $productContext = implode("\n", $lines);
            } else {
                $productContext = "Geen producten gevonden voor '{$searchQuery}'.";
            }
        }

        // Step 3: build reply
        if ($searchQuery && $productContext && strpos($productContext, "Geen producten") === false) {
            // Found products → AI answers
            $reply = $this->generateReply($message, $productContext);

        } else {
            // No results, no keyword, greeting, or general question → top 5 fallback
            $top5 = $this->productenService->getTopProductsForAi();
            $topContext = implode("\n", array_map(
                fn($p) => "- {$p['name']} | €{$p['price']}",
                $top5
            ));

            $reply = $this->generateReply($message, "")
                . "\n\nOnze populairste producten:\n"
                . $topContext;
        }

        echo json_encode([
            "search" => $searchQuery,
            "reply"  => $reply ?: "Geen antwoord ontvangen"
        ]);
    }

    private function normalizeKeyword(string $keyword): string
    {
        $synonyms = [
            'clean'         => 'cleaner',
            'claning'       => 'cleaner',
            'cleaning'      => 'cleaner',
            'cleaner'       => 'cleaner',
            'reinigen'      => 'cleaner',
            'reiniging'     => 'cleaner',
            'reiniger'      => 'cleaner',
            'schoonmaak'    => 'cleaner',
            'schoonmaken'   => 'cleaner',
            'schoonmaker'   => 'cleaner',
            'beschermen'    => 'protect',
            'bescherming'   => 'protect',
            'protectie'     => 'protect',
            'protection'    => 'protect',
            'protect'       => 'protect',
            'sealer'        => 'protect',
            'nano'          => 'protect',
            'onderhoud'     => 'maintenance',
            'maintenance'   => 'maintenance',
            'maintain'      => 'maintenance',
            'wax'           => 'wax',
            'wassen'        => 'wax',
            'poetsen'       => 'wax',
            'polish'        => 'wax',
            'toebehoren'    => 'accessory',
            'accessoires'   => 'accessory',
            'accessory'     => 'accessory',
            'doek'          => 'cloth',
            'spons'         => 'sponge',
            'borstel'       => 'brush',
            'steen'         => 'stone',
            'stone'         => 'stone',
            'marmer'        => 'stone',
            'graniet'       => 'stone',
        ];

        $lower = strtolower(trim($keyword));

        if (isset($synonyms[$lower])) {
            return $synonyms[$lower];
        }

        foreach ($synonyms as $word => $replacement) {
            if (str_contains($lower, $word)) {
                return $replacement;
            }
        }

        return $lower;
    }

    private function extractSearchKeyword(string $message): ?string
    {
        $systemPrompt = <<<EOT
You are a keyword extractor for a webshop.

Return ONLY raw JSON, nothing else. No explanation. No markdown.

Rules:
- If the message is a greeting (hello, hi, hoi, hallo, hey) → {"search": null}
- If the message asks about a product → {"search": "keyword"}
- If the message is a general question (shipping, returns, hours) → {"search": null}

Examples:
"hello" → {"search": null}
"hoi" → {"search": null}
"do you have stone cleaner?" → {"search": "cleaner"}
"wat kost de wax?" → {"search": "wax"}
"what are your opening hours?" → {"search": null}
"what is your best cleaning product?" → {"search": "cleaning"}
EOT;

        $response = $this->callAi($systemPrompt, $message, 50);
        error_log("KEYWORD RAW: " . $response);

        preg_match('/\{.*?\}/s', $response, $matches);
        $decoded = json_decode($matches[0] ?? '{}', true);

        $kw = $decoded['search'] ?? null;

        if (!$kw || strlen(trim($kw)) < 2) {
            return null;
        }

        return trim($kw);
    }

    private function generateReply(string $message, string $productContext): string
    {
        if ($productContext) {
            $systemPrompt = <<<EOT
Je bent klantenservice voor CleanStone.
Beantwoord ALLEEN op basis van de producten hieronder.
Noem naam + prijs. Max 3 zinnen. Nederlands.

Producten:
{$productContext}
EOT;
        } else {
            $systemPrompt = <<<EOT
Je bent een vriendelijke klantenservice medewerker voor CleanStone, een webshop voor steenverzorging.
Reageer natuurlijk en vriendelijk in het Nederlands.
Max 2 zinnen. Stel geen vragen over producten.
EOT;
        }

        return $this->callAi($systemPrompt, $message, 200);
    }

    private function callAi(string $systemPrompt, string $userMessage, int $maxTokens = 300): string
    {
        $payload = json_encode([
            "model" => "llama3",
            "messages" => [
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $userMessage]
            ],
            "stream" => false,
            "options" => [
                "num_predict" => $maxTokens,
                "temperature" => 0.3
            ]
        ]);

        $ch = curl_init("http://localhost:11434/api/chat");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS     => $payload
        ]);

        $response = curl_exec($ch);
        error_log("OLLAMA RAW: " . $response);

        if ($response === false) {
            error_log("CURL ERROR: " . curl_error($ch));
            curl_close($ch);
            return "";
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (!isset($data['message']['content'])) {
            error_log("OLLAMA ERROR: " . $response);
            return "";
        }

        return trim($data['message']['content']);
    }
}