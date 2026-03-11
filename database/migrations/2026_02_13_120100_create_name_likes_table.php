<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('name_likes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('name_id')->constrained()->cascadeOnDelete();
            $table->string('ip_hash', 64)->nullable();
            $table->string('voter_token_hash', 64)->nullable();
            $table->timestamps();

            $table->unique(['name_id', 'ip_hash']);
            $table->unique(['name_id', 'voter_token_hash']);
            $table->index('name_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('name_likes');
    }
};
