<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'featured_image', 'author',
        'published_at', 'is_published', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');
    }

    public function featuredImageUrl(): ?string
    {
        return PublicStorage::url($this->featured_image);
    }

    public function readingTimeMinutes(): int
    {
        $words = str_word_count(strip_tags((string) $this->body));

        return max(1, (int) ceil($words / 200));
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function seoDescription(): ?string
    {
        return $this->meta_description ?: $this->excerpt;
    }

    /**
     * Article HTML with accessible table wrappers for insight prose styling.
     */
    public function renderedBody(): string
    {
        $body = (string) $this->body;

        if ($body === '' || ! str_contains(strtolower($body), '<table')) {
            return $body;
        }

        return (string) preg_replace_callback(
            '/<table\b[^>]*>[\s\S]*?<\/table>/i',
            static fn (array $match): string => '<div class="insight-table-wrap">'.$match[0].'</div>',
            $body,
        );
    }
}
