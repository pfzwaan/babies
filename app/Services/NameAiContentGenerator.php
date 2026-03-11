<?php

namespace App\Services;

use App\Models\GlobalContent;
use App\Models\Name;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class NameAiContentGenerator
{
    public function generateForName(Name $name): array
    {
        $settings = GlobalContent::singleton();
        $apiKey = trim((string) ($settings->name_ai_openai_api_key ?? ''));
        $targets = collect($settings->name_ai_targets ?? [])->map(fn ($item) => (string) $item)->all();

        if (! in_array('names', $targets, true)) {
            throw new RuntimeException('AI generation for Names staat uit. Activeer "Names" in Global Contents > Name AI Generator > Generate for.');
        }

        if ($apiKey === '') {
            throw new RuntimeException('OpenAI API key ontbreekt. Stel deze in bij Global Contents > Name AI.');
        }

        $model = trim((string) ($settings->name_ai_model ?: 'gpt-4o-mini'));
        $temperature = $settings->name_ai_temperature ?? 0.7;
        $maxTokens = $settings->name_ai_max_tokens ?? 1400;
        $keywords = trim((string) ($settings->name_ai_keywords ?? ''));
        $categoryName = (string) optional($name->nameCategory)->name;
        $gender = trim((string) ($name->gender ?? ''));

        $promptTemplate = trim((string) ($settings->name_ai_prompt ?? ''));
        if ($promptTemplate === '') {
            $promptTemplate = $this->defaultPromptTemplate();
        }

        $prompt = strtr($promptTemplate, [
            '{{name}}' => $name->title,
            '{{category}}' => $categoryName,
            '{{gender}}' => $gender,
            '{{keywords}}' => $keywords,
        ]);

        $response = Http::withToken($apiKey)
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'temperature' => (float) $temperature,
                'max_tokens' => (int) $maxTokens,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Je bent een Nederlandstalige copywriter voor huisdiernamen. Geef alleen geldige JSON terug.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ]);

        if (! $response->successful()) {
            $message = $response->json('error.message') ?: $response->body();
            throw new RuntimeException('OpenAI request mislukt: ' . $message);
        }

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');
        $payload = $this->decodeJsonPayload($content);

        return $this->normalizePayload($payload, $name->title);
    }

    private function decodeJsonPayload(string $content): array
    {
        $decoded = json_decode(trim($content), true);

        if (is_array($decoded)) {
            return $decoded;
        }

        if (preg_match('/```json\s*(\{.*\})\s*```/s', $content, $matches) === 1) {
            $decoded = json_decode($matches[1], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        throw new RuntimeException('Kon AI JSON-output niet parsen.');
    }

    private function normalizePayload(array $payload, string $nameTitle): array
    {
        $related = array_values(array_filter(array_map(
            fn ($item) => is_string($item) ? trim($item) : '',
            (array) ($payload['related_names'] ?? [])
        )));

        $famousItems = array_values(array_filter(array_map(
            fn ($item) => is_string($item) ? trim($item) : '',
            (array) ($payload['famous_items'] ?? [])
        )));

        $originParagraphs = array_values(array_filter(array_map(
            fn ($item) => is_string($item) ? trim($item) : '',
            (array) ($payload['origin_paragraphs'] ?? [])
        )));

        return [
            'popularity_title' => (string) ($payload['popularity_title'] ?? "De populariteit van {$nameTitle}"),
            'popularity_text_1' => (string) ($payload['popularity_text_1'] ?? ''),
            'popularity_text_2' => (string) ($payload['popularity_text_2'] ?? ''),
            'trend_title' => (string) ($payload['trend_title'] ?? 'Populariteitstrend door de tijd heen'),
            'trend_text' => (string) ($payload['trend_text'] ?? ''),
            'origin_title' => (string) ($payload['origin_title'] ?? 'Toelichting herkomst en betekenis'),
            'origin_paragraphs' => $originParagraphs,
            'famous_title' => (string) ($payload['famous_title'] ?? "{$nameTitle} in de bekende personen"),
            'famous_intro' => (string) ($payload['famous_intro'] ?? ''),
            'famous_items' => $famousItems,
            'films_title' => (string) ($payload['films_title'] ?? 'Films en tv-series'),
            'films_text' => (string) ($payload['films_text'] ?? ''),
            'related_title' => (string) ($payload['related_title'] ?? 'Vergelijkbare namen met een vergelijkbare uitstraling'),
            'related_names' => $related,
            'generated_at' => now()->toIso8601String(),
        ];
    }

    private function defaultPromptTemplate(): string
    {
        return <<<PROMPT
Schrijf Nederlandse content voor een single pagina van een huisdiernaam.

Input:
- Name: {{name}}
- Category: {{category}}
- Gender: {{gender}}
- Keywords: {{keywords}}

Geef ALLEEN JSON met exact deze keys:
{
  "popularity_title": string,
  "popularity_text_1": string,
  "popularity_text_2": string,
  "trend_title": string,
  "trend_text": string,
  "origin_title": string,
  "origin_paragraphs": string[],
  "famous_title": string,
  "famous_intro": string,
  "famous_items": string[],
  "films_title": string,
  "films_text": string,
  "related_title": string,
  "related_names": string[]
}

Vereisten:
- Schrijf in vloeiend Nederlands.
- Geen markdown.
- Minimaal 2 origin_paragraphs.
- Minimaal 4 famous_items.
- Minimaal 8 related_names.
- Houd het feitelijk neutraal en vermijd juridische/medische claims.
PROMPT;
    }
}
