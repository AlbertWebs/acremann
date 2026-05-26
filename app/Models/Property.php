<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'status', 'project_status', 'price_from', 'price_label',
        'plot_size', 'location', 'county', 'category', 'title_type', 'listing_type',
        'summary', 'description', 'amenities', 'map_embed', 'distance_notes',
        'tour_embed_url', 'brochure_path', 'title_process', 'investor_angle',
        'sustainability_markers', 'is_featured', 'is_published', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
            'sustainability_markers' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'price_from' => 'decimal:2',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    public function plots(): HasMany
    {
        return $this->hasMany(Plot::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(PropertyFaq::class)->orderBy('sort_order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('brochure')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->performOnCollections('hero', 'gallery');
    }

    /**
     * @return Collection<int, Media>
     */
    public function galleryMedia(): Collection
    {
        $items = collect();

        if ($hero = $this->getFirstMedia('hero')) {
            $items->push($hero);
        }

        return $items->merge($this->getMedia('gallery'));
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

    public function adminThumbnailPath(): ?string
    {
        $media = $this->getFirstMedia('hero') ?? $this->getFirstMedia('gallery');

        if (! $media) {
            return null;
        }

        $relative = $media->hasGeneratedConversion('preview')
            ? $media->getUrl('preview')
            : $media->getUrl();

        return PublicStorage::normalizePath($relative);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function formattedPrice(): string
    {
        if ($this->price_label) {
            return $this->price_label;
        }
        if ($this->price_from) {
            return 'KES '.number_format($this->price_from, 0);
        }

        return 'Contact for pricing';
    }

    public function hasPlotInventory(): bool
    {
        if ($this->relationLoaded('plots')) {
            return $this->plots->isNotEmpty();
        }

        return $this->plots()->exists();
    }

    /**
     * @return array{available: int, reserved: int, sold: int, total: int}
     */
    public function availabilityCounts(): array
    {
        $plots = $this->relationLoaded('plots') ? $this->plots : $this->plots()->get();

        if ($plots->isEmpty()) {
            return ['available' => 0, 'reserved' => 0, 'sold' => 0, 'total' => 0];
        }

        return [
            'available' => $plots->where('status', 'available')->count(),
            'reserved' => $plots->where('status', 'reserved')->count(),
            'sold' => $plots->where('status', 'sold')->count(),
            'total' => $plots->count(),
        ];
    }

    public function isSoldOut(): bool
    {
        if ($this->project_status === 'sold_out' || $this->status === 'sold') {
            return true;
        }

        $counts = $this->availabilityCounts();

        if ($counts['total'] === 0) {
            return false;
        }

        return $counts['available'] === 0 && $counts['reserved'] === 0;
    }

    /**
     * @return array{
     *     has_plots: bool,
     *     total: int,
     *     available: int,
     *     reserved: int,
     *     sold: int,
     *     remaining: int,
     *     is_sold_out: bool,
     *     label: string
     * }
     */
    public function availabilitySummary(): array
    {
        $counts = $this->availabilityCounts();

        return [
            'has_plots' => $counts['total'] > 0,
            'total' => $counts['total'],
            'available' => $counts['available'],
            'reserved' => $counts['reserved'],
            'sold' => $counts['sold'],
            'remaining' => $counts['available'],
            'is_sold_out' => $this->isSoldOut(),
            'label' => $this->availabilityDisplayLabel(),
        ];
    }

    public function availabilityDisplayLabel(): string
    {
        if ($this->isSoldOut()) {
            return 'Sold out';
        }

        $counts = $this->availabilityCounts();

        if ($counts['total'] === 0) {
            return match ($this->status) {
                'sold' => 'Sold out',
                'reserved' => 'Reserved',
                'coming_soon' => 'Coming soon',
                default => 'Available',
            };
        }

        $remaining = $counts['available'];
        $sold = $counts['sold'];
        $reserved = $counts['reserved'];

        if ($remaining === 0 && $reserved > 0) {
            return $reserved.' reserved · '.$sold.' sold';
        }

        $remainingLabel = $remaining.' '.str('plot')->plural($remaining).' remaining';

        return $sold > 0
            ? $remainingLabel.' · '.$sold.' sold'
            : $remainingLabel;
    }
}
