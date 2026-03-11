<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Name extends Model
{
    protected $fillable = [
        'site_id',
        'lang',
        'title',
        'slug',
        'gender',
        'name_category_id',
        'tags',
        'seo',
        'likes_count',
        'ai_content',
    ];

    protected $casts = [
        'tags' => 'array',
        'seo' => 'array',
        'ai_content' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $name): void {
            if (blank($name->slug) || $name->isDirty('title')) {
                $name->slug = self::generateUniqueSlug($name->title, $name->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $base = $base !== '' ? $base : 'name';
        $slug = $base;
        $counter = 2;

        while (
            self::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function nameCategory(): BelongsTo
    {
        return $this->belongsTo(NameCategory::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(NameLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(NameComment::class);
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->orderByDesc('likes_count')->orderBy('title');
    }
}
