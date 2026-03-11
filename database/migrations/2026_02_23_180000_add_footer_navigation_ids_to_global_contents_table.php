<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->foreignId('footer_navigation_2_id')
                ->nullable()
                ->after('footer_title_2')
                ->constrained('navigations')
                ->nullOnDelete();

            $table->foreignId('footer_navigation_3_id')
                ->nullable()
                ->after('footer_title_3')
                ->constrained('navigations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('footer_navigation_2_id');
            $table->dropConstrainedForeignId('footer_navigation_3_id');
        });
    }
};
