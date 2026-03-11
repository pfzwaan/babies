<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->json('name_ai_targets')->nullable()->after('name_ai_max_tokens');
        });
    }

    public function down(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropColumn('name_ai_targets');
        });
    }
};
