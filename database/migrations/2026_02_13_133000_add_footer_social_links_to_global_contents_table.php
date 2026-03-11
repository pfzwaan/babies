<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->string('footer_social_label')->nullable()->after('footer_content_4');
            $table->string('footer_social_facebook_url', 2048)->nullable()->after('footer_social_label');
            $table->string('footer_social_instagram_url', 2048)->nullable()->after('footer_social_facebook_url');
            $table->string('footer_social_tiktok_url', 2048)->nullable()->after('footer_social_instagram_url');
            $table->string('footer_social_youtube_url', 2048)->nullable()->after('footer_social_tiktok_url');
        });
    }

    public function down(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropColumn([
                'footer_social_label',
                'footer_social_facebook_url',
                'footer_social_instagram_url',
                'footer_social_tiktok_url',
                'footer_social_youtube_url',
            ]);
        });
    }
};
