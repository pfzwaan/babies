<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('names', 'lang')) {
            return;
        }

        Schema::table('names', function (Blueprint $table): void {
            $table->string('lang', 8)->nullable()->after('site_id');
            $table->index('lang');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('names', 'lang')) {
            return;
        }

        Schema::table('names', function (Blueprint $table): void {
            $table->dropIndex(['lang']);
            $table->dropColumn('lang');
        });
    }
};
