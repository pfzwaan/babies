<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class GlobalContent extends Model
{
    protected $fillable = [
        'site_id',
        'header_cta_label',
        'header_cta_url',
        'footer_title_1',
        'footer_content_1',
        'footer_title_2',
        'footer_navigation_2_id',
        'footer_content_2',
        'footer_title_3',
        'footer_navigation_3_id',
        'footer_content_3',
        'footer_title_4',
        'footer_content_4',
        'footer_social_label',
        'footer_social_facebook_url',
        'footer_social_instagram_url',
        'footer_social_tiktok_url',
        'footer_social_youtube_url',
        'contact_forms_title',
        'contact_forms_intro',
        'name_ai_openai_api_key',
        'name_ai_model',
        'name_ai_prompt',
        'name_ai_keywords',
        'name_ai_temperature',
        'name_ai_max_tokens',
        'name_ai_targets',
        'name_ai_names_mode',
    ];

    protected $casts = [
        'site_id' => 'integer',
        'footer_navigation_2_id' => 'integer',
        'footer_navigation_3_id' => 'integer',
        'name_ai_temperature' => 'float',
        'name_ai_max_tokens' => 'integer',
        'name_ai_targets' => 'array',
    ];

    public function footerNavigation2(): BelongsTo
    {
        return $this->belongsTo(Navigation::class, 'footer_navigation_2_id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function footerNavigation3(): BelongsTo
    {
        return $this->belongsTo(Navigation::class, 'footer_navigation_3_id');
    }

    public function getNameAiOpenaiApiKeyAttribute($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return Crypt::decryptString((string) $value);
        } catch (DecryptException) {
            // Legacy / invalid ciphertext for current APP_KEY: avoid hard crash in admin.
            return null;
        }
    }

    public function setNameAiOpenaiApiKeyAttribute($value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['name_ai_openai_api_key'] = null;

            return;
        }

        $this->attributes['name_ai_openai_api_key'] = Crypt::encryptString((string) $value);
    }

    public static function singleton(?int $siteId = null): self
    {
        $resolvedSiteId = $siteId ?? Site::resolveCurrent()?->id;

        return static::query()
            ->when($resolvedSiteId !== null, fn ($query) => $query->where('site_id', $resolvedSiteId))
            ->first()
            ?? static::query()->create(['site_id' => $resolvedSiteId]);
    }
}
