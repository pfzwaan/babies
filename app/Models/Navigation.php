<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Navigation extends Model
{
    protected $fillable = [
        'site_id',
        'name',
        'location',
        'status',
        'items',
    ];

    protected function casts(): array
    {
        return [
            'site_id' => 'integer',
            'items' => 'array',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public static function publishedForLocation(string $location, ?int $siteId = null): ?self
    {
        $resolvedSiteId = $siteId ?? Site::resolveCurrent()?->id;

        return self::query()
            ->when($resolvedSiteId !== null, fn ($query) => $query->where('site_id', $resolvedSiteId))
            ->where('location', $location)
            ->where('status', 'published')
            ->first();
    }

    public function resolvedItems(): array
    {
        $items = $this->items ?? [];

        return $this->resolveItems($items);
    }

    public function toFooterHtml(): string
    {
        $items = $this->flattenItems($this->resolvedItems());

        if ($items === []) {
            return '<ul></ul>';
        }

        $htmlItems = array_map(function (array $item): string {
            $label = e((string) ($item['label'] ?? ''));
            $url = trim((string) ($item['url'] ?? ''));

            if ($label === '') {
                return '';
            }

            if ($url === '' || $url === '#') {
                return "<li>&rsaquo; {$label}</li>";
            }

            $href = e($url);

            return "<li>&rsaquo; <a href=\"{$href}\">{$label}</a></li>";
        }, $items);

        $htmlItems = array_values(array_filter($htmlItems));

        return '<ul>' . implode('', $htmlItems) . '</ul>';
    }

    private function resolveItems(array $items): array
    {
        $pageIds = $this->collectPageIds($items);
        $nameCategoryIds = $this->collectNameCategoryIds($items);

        $pages = Page::query()
            ->whereIn('id', $pageIds)
            ->when($this->site_id !== null, fn ($query) => $query->where('site_id', $this->site_id))
            ->where('status', 'published')
            ->get(['id', 'title', 'slug'])
            ->keyBy('id');

        $nameCategories = NameCategory::query()
            ->when($this->site_id !== null, fn ($query) => $query->where('site_id', $this->site_id))
            ->whereIn('id', $nameCategoryIds)
            ->get(['id', 'name', 'slug'])
            ->keyBy('id');

        return $this->mapItems($items, $pages->all(), $nameCategories->all());
    }

    private function collectPageIds(array $items): array
    {
        $ids = [];

        foreach ($items as $item) {
            if (($item['type'] ?? null) === 'page' && ! blank($item['page_id'] ?? null)) {
                $ids[] = (int) $item['page_id'];
            }

            $children = Arr::get($item, 'children', []);

            if (is_array($children) && $children !== []) {
                $ids = [...$ids, ...$this->collectPageIds($children)];
            }
        }

        return array_values(array_unique($ids));
    }

    private function collectNameCategoryIds(array $items): array
    {
        $ids = [];

        foreach ($items as $item) {
            if (($item['type'] ?? null) === 'name_category' && ! blank($item['name_category_id'] ?? null)) {
                $ids[] = (int) $item['name_category_id'];
            }

            $children = Arr::get($item, 'children', []);

            if (is_array($children) && $children !== []) {
                $ids = [...$ids, ...$this->collectNameCategoryIds($children)];
            }
        }

        return array_values(array_unique($ids));
    }

    private function mapItems(array $items, array $pages, array $nameCategories): array
    {
        $mapped = [];

        foreach ($items as $item) {
            $type = $item['type'] ?? 'custom';
            $page = null;
            $nameCategory = null;
            $url = trim((string) ($item['url'] ?? ''));

            if ($type === 'page') {
                $page = $pages[(int) ($item['page_id'] ?? 0)] ?? null;

                if (! $page) {
                    continue;
                }

                $url = '/' . ltrim($page->slug, '/');
            }

            if ($type === 'name_category') {
                $nameCategory = $nameCategories[(int) ($item['name_category_id'] ?? 0)] ?? null;

                if (! $nameCategory) {
                    continue;
                }

                $url = '/' . ltrim((string) $nameCategory->slug, '/');
            }

            if ($url === '') {
                continue;
            }

            $label = trim((string) ($item['label'] ?? ($page?->title ?? $nameCategory?->name ?? '')));

            if ($label === '') {
                continue;
            }

            $mapped[] = [
                'label' => $label,
                'url' => $url,
                'open_in_new_tab' => (bool) ($item['open_in_new_tab'] ?? false),
                'children' => $this->mapItems(Arr::get($item, 'children', []), $pages, $nameCategories),
            ];
        }

        return $mapped;
    }

    private function flattenItems(array $items): array
    {
        $flat = [];

        foreach ($items as $item) {
            if (filled($item['label'] ?? null) && filled($item['url'] ?? null)) {
                $flat[] = [
                    'label' => (string) $item['label'],
                    'url' => (string) $item['url'],
                ];
            }

            $children = Arr::get($item, 'children', []);
            if (is_array($children) && $children !== []) {
                $flat = [...$flat, ...$this->flattenItems($children)];
            }
        }

        return $flat;
    }
}
