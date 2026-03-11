<?php

use App\Models\GlobalContent;
use App\Models\Navigation;
use App\Models\Site;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $sourceSite = Site::defaultSite();

        if (! $sourceSite) {
            return;
        }

        $sourceGlobal = GlobalContent::query()
            ->where('site_id', $sourceSite->id)
            ->first();

        $sourceNavigations = Navigation::query()
            ->where('site_id', $sourceSite->id)
            ->get();

        foreach (Site::query()->whereKeyNot($sourceSite->id)->get() as $site) {
            if ($sourceGlobal && ! GlobalContent::query()->where('site_id', $site->id)->exists()) {
                $clone = $sourceGlobal->replicate();
                $clone->site_id = $site->id;
                $clone->footer_navigation_2_id = null;
                $clone->footer_navigation_3_id = null;
                $clone->save();
            }

            foreach ($sourceNavigations as $navigation) {
                Navigation::query()->firstOrCreate(
                    [
                        'site_id' => $site->id,
                        'location' => $navigation->location,
                    ],
                    [
                        'name' => $navigation->name,
                        'status' => $navigation->status,
                        'items' => $navigation->items,
                    ]
                );
            }

            $siteGlobal = GlobalContent::query()->where('site_id', $site->id)->first();

            if ($siteGlobal) {
                $footerNavigation2 = Navigation::query()
                    ->where('site_id', $site->id)
                    ->where('location', optional($sourceGlobal?->footerNavigation2)->location)
                    ->value('id');

                $footerNavigation3 = Navigation::query()
                    ->where('site_id', $site->id)
                    ->where('location', optional($sourceGlobal?->footerNavigation3)->location)
                    ->value('id');

                $siteGlobal->forceFill([
                    'footer_navigation_2_id' => $footerNavigation2,
                    'footer_navigation_3_id' => $footerNavigation3,
                ])->save();
            }
        }
    }

    public function down(): void
    {
        $sourceSite = Site::defaultSite();

        if (! $sourceSite) {
            return;
        }

        GlobalContent::query()
            ->where('site_id', '!=', $sourceSite->id)
            ->delete();

        Navigation::query()
            ->where('site_id', '!=', $sourceSite->id)
            ->delete();
    }
};
