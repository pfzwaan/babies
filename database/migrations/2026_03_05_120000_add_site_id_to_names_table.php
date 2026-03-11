<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('names', 'site_id')) {
            Schema::table('names', function (Blueprint $table) {
                $table->foreignId('site_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('sites')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            });
        }

        $siteId = DB::table('sites')->where('id', 1)->value('id');
        if (! $siteId) {
            $siteId = DB::table('sites')->orderBy('id')->value('id');
        }

        if ($siteId) {
            DB::table('names')
                ->whereNull('site_id')
                ->update(['site_id' => $siteId]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('names', 'site_id')) {
            return;
        }

        Schema::table('names', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });
    }
};

