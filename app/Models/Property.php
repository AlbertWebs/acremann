<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
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

    public function availabilityCounts(): array
    {
        $plots = $this->plots;
        if ($plots->isEmpty()) {
            return ['available' => 1, 'reserved' => 0, 'sold' => 0];
        }

        return [
            'available' => $plots->where('status', 'available')->count(),
            'reserved' => $plots->where('status', 'reserved')->count(),
            'sold' => $plots->where('status', 'sold')->count(),
        ];
    }
}
