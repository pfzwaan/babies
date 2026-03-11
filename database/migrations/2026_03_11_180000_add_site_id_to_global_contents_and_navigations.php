<?php

use App\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('global_contents', 'site_id')) {
            Schema::table('global_contents', function (Blueprint $table): void {
                $table->foreignId('site_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('navigations', 'site_id')) {
            Schema::table('navigations', function (Blueprint $table): void {
                $table->foreignId('site_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        $defaultSiteId = Site::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->value('id');

        if ($defaultSiteId) {
            DB::table('global_contents')
                ->whereNull('site_id')
                ->update(['site_id' => $defaultSiteId]);

            DB::table('navigations')
                ->whereNull('site_id')
                ->update(['site_id' => $defaultSiteId]);
        }

        Schema::table('global_contents', function (Blueprint $table): void {
            $table->unique('site_id', 'global_contents_site_id_unique');
        });

        Schema::table('navigations', function (Blueprint $table): void {
            $table->dropUnique('navigations_location_unique');
            $table->unique(['site_id', 'location'], 'navigations_site_id_location_unique');
        });
    }

    public function down(): void
    {
        Schema::table('navigations', function (Blueprint $table): void {
            $table->dropUnique('navigations_site_id_location_unique');
            $table->unique('location', 'navigations_location_unique');
        });

        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropUnique('global_contents_site_id_unique');
        });

        if (Schema::hasColumn('navigations', 'site_id')) {
            Schema::table('navigations', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('site_id');
            });
        }

        if (Schema::hasColumn('global_contents', 'site_id')) {
            Schema::table('global_contents', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('site_id');
            });
        }
    }
};
