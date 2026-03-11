<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class NameCategory extends Model
{
    protected $fillable = [
        'site_id',
        'name',
        'slug',
    ];

    protected $casts = [
        'site_id' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $nameCategory): void {
            if (blank($nameCategory->slug) || $nameCategory->isDirty('name')) {
                $nameCategory->slug = self::generateUniqueSlug($nameCategory->name, $nameCategory->site_id, $nameCategory->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $name, ?int $siteId = null, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $base = $base !== '' ? $base : 'name-category';
        $slug = $base;
        $counter = 2;

        while (
            self::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->when($siteId !== null, fn ($query) => $query->where('site_id', $siteId))
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

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $routeField = $field ?? $this->getRouteKeyName();
        $siteId = Site::resolveCurrent()?->id;

        return $this->newQuery()
            ->when($siteId, fn ($query) => $query->where('site_id', $siteId))
            ->where($routeField, $value)
            ->first();
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function names(): HasMany
    {
        return $this->hasMany(Name::class);
    }

    public function scopeForSite(Builder $query, ?int $siteId): Builder
    {
        return $siteId ? $query->where('site_id', $siteId) : $query;
    }
}
