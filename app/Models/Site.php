<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Site extends Model
{
    public const DEFAULT_THEME = 'default';
    public const ENABLED_THEMES = [
        'default',
        'babies',
    ];

    public const THEMES = [
        'babies' => 'Babies',
        'default' => 'Default',
    ];

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'locale',
        'theme',
        'noindex',
        'is_active',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $site): void {
            if (blank($site->slug) || $site->isDirty('name')) {
                $site->slug = self::generateUniqueSlug($site->name, $site->id);
            }

            $site->theme = self::resolveTheme((string) $site->theme);
        });
    }

    public static function availableThemes(): array
    {
        $themesPath = resource_path('views/themes');
        if (! is_dir($themesPath)) {
            return [self::DEFAULT_THEME];
        }

        $themeDirs = collect(scandir($themesPath) ?: [])
            ->filter(fn (string $name): bool => ! in_array($name, ['.', '..'], true))
            ->filter(fn (string $name): bool => is_dir($themesPath . DIRECTORY_SEPARATOR . $name))
            ->values()
            ->all();

        if ($themeDirs === []) {
            return [self::DEFAULT_THEME];
        }

        $enabled = array_values(array_intersect(self::ENABLED_THEMES, $themeDirs));

        return $enabled !== [] ? $enabled : [self::DEFAULT_THEME];
    }

    public static function themeOptions(): array
    {
        return collect(self::availableThemes())
            ->mapWithKeys(fn (string $theme): array => [
                $theme => self::THEMES[$theme] ?? Str::of($theme)->replace(['-', '_'], ' ')->title()->value(),
            ])
            ->all();
    }

    public static function resolveTheme(?string $theme): string
    {
        $requested = blank($theme) ? self::DEFAULT_THEME : (string) $theme;

        return in_array($requested, self::availableThemes(), true)
            ? $requested
            : self::DEFAULT_THEME;
    }

    public function getResolvedThemeAttribute(): string
    {
        return self::resolveTheme($this->theme);
    }

    public function getThemeClassAttribute(): string
    {
        return 'theme-' . $this->resolved_theme;
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $base = $base !== '' ? $base : 'site';
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

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function names(): HasMany
    {
        return $this->hasMany(Name::class);
    }
}
