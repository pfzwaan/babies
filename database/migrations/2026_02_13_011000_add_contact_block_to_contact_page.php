<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('pages')
            ->where('slug', 'contact')
            ->first(['id', 'content']);

        if (! $page) {
            return;
        }

        $content = [];

        if (is_string($page->content) && $page->content !== '') {
            $decoded = json_decode($page->content, true);

            if (is_array($decoded)) {
                $content = $decoded;
            }
        }

        $hasContactBlock = collect($content)->contains(
            fn ($block) => is_array($block) && (($block['type'] ?? null) === 'contact')
        );

        if ($hasContactBlock) {
            return;
        }

        $content[] = [
            'type' => 'contact',
            'data' => [
                'show_second_form' => true,
            ],
        ];

        DB::table('pages')
            ->where('id', $page->id)
            ->update([
                'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        $page = DB::table('pages')
            ->where('slug', 'contact')
            ->first(['id', 'content']);

        if (! $page || ! is_string($page->content) || $page->content === '') {
            return;
        }

        $content = json_decode($page->content, true);
        if (! is_array($content)) {
            return;
        }

        $filtered = array_values(array_filter(
            $content,
            fn ($block) => ! (is_array($block) && (($block['type'] ?? null) === 'contact'))
        ));

        DB::table('pages')
            ->where('id', $page->id)
            ->update([
                'content' => json_encode($filtered, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
    }
};
