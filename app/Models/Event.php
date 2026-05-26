<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'description', 'location',
        'event_date', 'published_at', 'is_published', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->width(1200)
            ->height(900)
            ->performOnCollections('cover', 'gallery');
    }

    public function scopePublished($query)
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('event_date')
            ->orderByDesc('published_at');
    }

    public function coverUrl(): ?string
    {
        return $this->mediaUrl($this->getFirstMedia('cover'));
    }

    public function heroImageUrl(): ?string
    {
        if ($url = $this->coverUrl()) {
            return $url;
        }

        $firstGallery = $this->getFirstMedia('gallery');

        return $firstGallery ? $this->mediaUrl($firstGallery, null) : null;
    }

    /**
     * Disk-relative path for Filament admin thumbnails (public disk).
     */
    public function adminCoverPath(): ?string
    {
        $media = $this->getFirstMedia('cover') ?? $this->getFirstMedia('gallery');

        if (! $media) {
            return null;
        }

        $relative = ($media->hasGeneratedConversion('preview'))
            ? $media->getUrl('preview')
            : $media->getUrl();

        return PublicStorage::normalizePath($relative);
    }

    public function mediaUrl(?Media $media, ?string $conversion = 'preview'): ?string
    {
        if (! $media) {
            return null;
        }

        $relative = ($conversion && $media->hasGeneratedConversion($conversion))
            ? $media->getUrl($conversion)
            : $media->getUrl();

        return PublicStorage::absoluteUrl($relative);
    }
}
