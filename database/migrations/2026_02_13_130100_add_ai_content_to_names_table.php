<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('names', function (Blueprint $table): void {
            $table->json('ai_content')->nullable()->after('likes_count');
        });
    }

    public function down(): void
    {
        Schema::table('names', function (Blueprint $table): void {
            $table->dropColumn('ai_content');
        });
    }
};
