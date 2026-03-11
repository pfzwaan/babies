<?php

use App\Models\NameCategory;
use App\Models\Name;
use App\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('name_categories', 'site_id')) {
            Schema::table('name_categories', function (Blueprint $table): void {
                $table->foreignId('site_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        $defaultSite = Site::defaultSite();

        if ($defaultSite) {
            DB::table('name_categories')
                ->whereNull('site_id')
                ->update(['site_id' => $defaultSite->id]);
        }

        Schema::table('name_categories', function (Blueprint $table): void {
            $table->dropUnique('name_categories_name_unique');
            $table->dropUnique('name_categories_slug_unique');
            $table->unique(['site_id', 'name'], 'name_categories_site_id_name_unique');
            $table->unique(['site_id', 'slug'], 'name_categories_site_id_slug_unique');
        });

        if (! $defaultSite) {
            return;
        }

        $sourceCategories = NameCategory::query()
            ->where('site_id', $defaultSite->id)
            ->orderBy('id')
            ->get();

        foreach (Site::query()->whereKeyNot($defaultSite->id)->get() as $site) {
            $categoryMap = [];

            foreach ($sourceCategories as $category) {
                $clone = NameCategory::query()->firstOrCreate(
                    [
                        'site_id' => $site->id,
                        'slug' => $category->slug,
                    ],
                    [
                        'name' => $category->name,
                    ]
                );

                $categoryMap[$category->id] = $clone->id;
            }

            foreach ($categoryMap as $sourceCategoryId => $targetCategoryId) {
                Name::query()
                    ->where('site_id', $site->id)
                    ->where('name_category_id', $sourceCategoryId)
                    ->update(['name_category_id' => $targetCategoryId]);
            }

            DB::table('navigations')
                ->where('site_id', $site->id)
                ->orderBy('id')
                ->select(['id', 'items'])
                ->get()
                ->each(function (object $navigation) use ($categoryMap): void {
                    $items = json_decode((string) ($navigation->items ?? '[]'), true);

                    if (! is_array($items)) {
                        return;
                    }

                    $items = $this->remapCategoryIds($items, $categoryMap);

                    DB::table('navigations')
                        ->where('id', $navigation->id)
                        ->update(['items' => json_encode($items)]);
                });
        }
    }

    public function down(): void
    {
        Schema::table('name_categories', function (Blueprint $table): void {
            $table->dropUnique('name_categories_site_id_name_unique');
            $table->dropUnique('name_categories_site_id_slug_unique');
            $table->unique('name', 'name_categories_name_unique');
            $table->unique('slug', 'name_categories_slug_unique');
        });

        if (Schema::hasColumn('name_categories', 'site_id')) {
            Schema::table('name_categories', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('site_id');
            });
        }
    }

    private function remapCategoryIds(array $items, array $categoryMap): array
    {
        foreach ($items as $index => $item) {
            if (($item['type'] ?? null) === 'name_category' && isset($item['name_category_id'])) {
                $sourceId = (int) $item['name_category_id'];

                if (isset($categoryMap[$sourceId])) {
                    $items[$index]['name_category_id'] = $categoryMap[$sourceId];
                }
            }

            $children = $item['children'] ?? [];

            if (is_array($children) && $children !== []) {
                $items[$index]['children'] = $this->remapCategoryIds($children, $categoryMap);
            }
        }

        return $items;
    }
};
