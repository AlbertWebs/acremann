<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'summary',
        'featured_image',
        'header_image',
        'body',
        'local_summary',
        'diaspora_summary',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function featuredImageUrl(): ?string
    {
        return PublicStorage::url($this->featured_image);
    }

    public function headerImageUrl(): ?string
    {
        return PublicStorage::url($this->header_image);
    }

    public function plainSummary(): string
    {
        if (blank($this->summary)) {
            return '';
        }

        $text = html_entity_decode($this->summary, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::squish(strip_tags($text));
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: "{$this->title} | Acremann Properties Kenya";
    }

    public function seoDescription(): string
    {
        if (filled($this->meta_description)) {
            return $this->meta_description;
        }

        return $this->plainSummary() ?: 'Professional property services in Kenya for local buyers and diaspora investors — clean titles, transparent advisory.';
    }

    public function plainLocalSummary(): string
    {
        return $this->plainTextField($this->local_summary);
    }

    public function plainDiasporaSummary(): string
    {
        return $this->plainTextField($this->diaspora_summary);
    }

    protected function plainTextField(?string $value): string
    {
        if (blank($value)) {
            return '';
        }

        $text = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::squish(strip_tags($text));
    }
}
