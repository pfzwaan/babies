<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->string('contact_forms_title')->nullable()->after('footer_content_4');
            $table->longText('contact_forms_intro')->nullable()->after('contact_forms_title');
            $table->string('contact_form_1_label')->nullable()->after('contact_forms_intro');
            $table->longText('contact_form_1_embed')->nullable()->after('contact_form_1_label');
            $table->string('contact_form_2_label')->nullable()->after('contact_form_1_embed');
            $table->longText('contact_form_2_embed')->nullable()->after('contact_form_2_label');
        });
    }

    public function down(): void
    {
        Schema::table('global_contents', function (Blueprint $table): void {
            $table->dropColumn([
                'contact_forms_title',
                'contact_forms_intro',
                'contact_form_1_label',
                'contact_form_1_embed',
                'contact_form_2_label',
                'contact_form_2_embed',
            ]);
        });
    }
};
