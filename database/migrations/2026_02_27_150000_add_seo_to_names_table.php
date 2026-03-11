<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('names', function (Blueprint $table): void {
            if (! Schema::hasColumn('names', 'seo')) {
                $table->json('seo')->nullable()->after('tags');
            }
        });
    }

    public function down(): void
    {
        Schema::table('names', function (Blueprint $table): void {
            if (Schema::hasColumn('names', 'seo')) {
                $table->dropColumn('seo');
            }
        });
    }
};
