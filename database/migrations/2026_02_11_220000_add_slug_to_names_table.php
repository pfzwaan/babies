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
        if (! Schema::hasColumn('names', 'slug')) {
            Schema::table('names', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('title');
            });
        }

        $usedSlugs = DB::table('names')
            ->whereNotNull('slug')
            ->pluck('slug')
            ->map(static fn (string $slug): string => mb_strtolower($slug))
            ->all();

        DB::table('names')
            ->orderBy('id')
            ->whereNull('slug')
            ->select(['id', 'title'])
            ->get()
            ->each(function (object $row) use (&$usedSlugs): void {
                $base = Str::slug((string) $row->title);
                $base = $base !== '' ? $base : 'name';
                $slug = $base;
                $counter = 2;

                while (in_array(mb_strtolower($slug), $usedSlugs, true)) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }

                $usedSlugs[] = mb_strtolower($slug);

                DB::table('names')
                    ->where('id', $row->id)
                    ->update(['slug' => $slug]);
            });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('names', 'slug')) {
            return;
        }

        try {
            Schema::table('names', function (Blueprint $table) {
                $table->dropUnique('names_slug_unique');
            });
        } catch (\Throwable) {
            // Ignore when unique index does not exist.
        }

        Schema::table('names', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
