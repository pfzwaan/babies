<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'footer_title_1' => 'Over Dierennamengids.nl',
            'footer_content_1' => '<p>Welkom op de website vol met dierennamen! Dierennamengids.nl is de meest complete website in Nederland voor wat betreft dierennamen. Of je nu zoekt naar namen voor een hond of konijn. Dierennamengids.nl heeft voor ieder wat wils!</p>',
            'footer_title_2' => 'Menu',
            'footer_content_2' => '<ul><li>&rsaquo; Home</li><li>&rsaquo; Hondennamen</li><li>&rsaquo; Hondennamen reu</li><li>&rsaquo; Hondennamen teefje</li><li>&rsaquo; Kattennamen</li><li>&rsaquo; Paardennamen</li><li>&rsaquo; Kippennamen</li><li>&rsaquo; Konijnennamen</li><li>&rsaquo; Cavia namen</li><li>&rsaquo; Hamsternamen</li><li>&rsaquo; Vissennamen</li><li>&rsaquo; Vogelnamen</li></ul>',
            'footer_title_3' => 'Handige links',
            'footer_content_3' => '<ul><li>&rsaquo; Privacy Policy</li><li>&rsaquo; Disclaimer</li><li>&rsaquo; Over ons</li><li>&rsaquo; Adverteren</li><li>&rsaquo; Interessant</li></ul>',
            'footer_title_4' => 'Vragen?',
            'footer_content_4' => '<p>Bel ons gerust als u vragen heeft</p><p><span style="color:#84CC16;">Ma - Vr :</span> 09.00 - 16.00</p><p><span style="color:#84CC16;">Weekend :</span> Gesloten</p>',
        ];

        $record = DB::table('global_contents')->orderBy('id')->first();
        $now = now();

        if (! $record) {
            DB::table('global_contents')->insert($defaults + [
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return;
        }

        DB::table('global_contents')
            ->where('id', $record->id)
            ->update($defaults + ['updated_at' => $now]);
    }

    public function down(): void
    {
        // no-op
    }
};
