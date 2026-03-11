<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('global_contents', function (Blueprint $table) {
            $table->id();
            $table->string('header_cta_label')->nullable();
            $table->string('header_cta_url', 2048)->nullable();
            $table->string('footer_title_1')->nullable();
            $table->longText('footer_content_1')->nullable();
            $table->string('footer_title_2')->nullable();
            $table->longText('footer_content_2')->nullable();
            $table->string('footer_title_3')->nullable();
            $table->longText('footer_content_3')->nullable();
            $table->string('footer_title_4')->nullable();
            $table->longText('footer_content_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_contents');
    }
};
