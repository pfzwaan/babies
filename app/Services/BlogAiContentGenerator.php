<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\GlobalContent;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class BlogAiContentGenerator
{
    public function generateForBlog(Blog $blog): array
    {
        $settings = GlobalContent::singleton();
        $apiKey = trim((string) ($settings->name_ai_openai_api_key ?? ''));
        $targets = collect($settings->name_ai_targets ?? [])->map(fn ($item) => (string) $item)->all();

        if (! in_array('blogs', $targets, true)) {
            throw new RuntimeException('AI generation for Blogs staat uit. Activeer "Blogs" in Global Contents > Name AI Generator > Generate for.');
        }

        if ($apiKey === '') {
            throw new RuntimeException('OpenAI API key ontbreekt. Stel deze in bij Global Contents > Name AI.');
        }

        $model = trim((string) ($settings->name_ai_model ?: 'gpt-4o-mini'));
        $temperature = $settings->name_ai_temperature ?? 0.7;
        $maxTokens = $settings->name_ai_max_tokens ?? 1400;
        $keywords = trim((string) ($settings->name_ai_keywords ?? ''));
        $categoryName = (string) optional($blog->blogCategory)->name;

        $prompt = <<<PROMPT
Schrijf Nederlandse blogcontent voor een huisdieren-website.

Input:
- Titel: {$blog->title}
- Categorie: {$categoryName}
- Keywords: {$keywords}

Geef ALLEEN geldige JSON met exact deze keys:
{
  "excerpt": "string",
  "content_html": "string"
}

Vereisten:
- excerpt: 1 korte alinea, max 220 tekens.
- content_html: minimaal 4 paragrafen HTML met <p>...</p>, zonder markdown.
- Geen codeblokken, geen extra keys.
PROMPT;

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
                        'content' => 'Je bent een Nederlandstalige copywriter. Geef alleen geldige JSON terug.',
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

        $excerpt = trim((string) ($payload['excerpt'] ?? ''));
        $html = trim((string) ($payload['content_html'] ?? ''));

        if ($excerpt === '' || $html === '') {
            throw new RuntimeException('AI-output voor blog bevat geen geldige excerpt/content.');
        }

        return [
            'excerpt' => $excerpt,
            'content' => $html,
        ];
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
}
