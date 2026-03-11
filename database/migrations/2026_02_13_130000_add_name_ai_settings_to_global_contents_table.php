<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->text('name_ai_openai_api_key')->nullable()->after('contact_forms_intro');
            $table->string('name_ai_model')->nullable()->after('name_ai_openai_api_key');
            $table->longText('name_ai_prompt')->nullable()->after('name_ai_model');
            $table->text('name_ai_keywords')->nullable()->after('name_ai_prompt');
            $table->decimal('name_ai_temperature', 3, 2)->nullable()->after('name_ai_keywords');
            $table->unsignedInteger('name_ai_max_tokens')->nullable()->after('name_ai_temperature');
        });
    }

    public function down(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropColumn([
                'name_ai_openai_api_key',
                'name_ai_model',
                'name_ai_prompt',
                'name_ai_keywords',
                'name_ai_temperature',
                'name_ai_max_tokens',
            ]);
        });
    }
};
