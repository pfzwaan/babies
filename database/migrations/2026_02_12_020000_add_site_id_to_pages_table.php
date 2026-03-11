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
        if (! Schema::hasColumn('pages', 'site_id')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->foreignId('site_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('sites')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            });
        }

        $siteId = DB::table('sites')->orderBy('id')->value('id');

        if (! $siteId) {
            $name = 'Default Site';
            $baseSlug = Str::slug($name);
            $slug = $baseSlug !== '' ? $baseSlug : 'site';
            $counter = 2;

            while (DB::table('sites')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $siteId = DB::table('sites')->insertGetId([
                'name' => $name,
                'slug' => $slug,
                'domain' => null,
                'locale' => 'nl',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('pages')
            ->whereNull('site_id')
            ->update(['site_id' => $siteId]);
    }

    public function down(): void
    {
        if (! Schema::hasColumn('pages', 'site_id')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });
    }
};
