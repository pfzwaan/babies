<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('name_categories', 'slug')) {
            Schema::table('name_categories', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        $usedSlugs = DB::table('name_categories')
            ->whereNotNull('slug')
            ->pluck('slug')
            ->map(static fn (string $slug): string => mb_strtolower($slug))
            ->all();

        DB::table('name_categories')
            ->orderBy('id')
            ->whereNull('slug')
            ->select(['id', 'name'])
            ->get()
            ->each(function (object $row) use (&$usedSlugs): void {
                $base = Str::slug((string) $row->name);
                $base = $base !== '' ? $base : 'name-category';
                $slug = $base;
                $counter = 2;

                while (in_array(mb_strtolower($slug), $usedSlugs, true)) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }

                $usedSlugs[] = mb_strtolower($slug);

                DB::table('name_categories')
                    ->where('id', $row->id)
                    ->update(['slug' => $slug]);
            });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('name_categories', 'slug')) {
            return;
        }

        try {
            Schema::table('name_categories', function (Blueprint $table) {
                $table->dropUnique('name_categories_slug_unique');
            });
        } catch (\Throwable) {
            // Ignore when unique index does not exist.
        }

        Schema::table('name_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

