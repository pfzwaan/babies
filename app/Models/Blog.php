<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'blog_category_id',
        'thumbnail',
        'excerpt',
        'content',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    protected static function booted(): void
    {
        static::saving(function (self $blog): void {
            if (blank($blog->slug) || $blog->isDirty('title')) {
                $blog->slug = self::generateUniqueSlug($blog->title, $blog->id);
            }

            if ($blog->status === 'published' && blank($blog->published_at)) {
                $blog->published_at = now();
            }

            if ($blog->status !== 'published') {
                $blog->published_at = null;
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $base = $base !== '' ? $base : 'blog';
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
}
