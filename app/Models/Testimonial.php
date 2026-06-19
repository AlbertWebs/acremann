<?php

namespace App\Models;

use App\Support\PublicStorage;
use App\Support\TestimonialPhotoProcessor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    protected $fillable = [
        'quote', 'client_name', 'client_detail', 'photo_path', 'property_id',
        'is_featured', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function photoUrl(): ?string
    {
        $variants = TestimonialPhotoProcessor::existingVariantPaths($this->photo_path);

        if ($variants !== []) {
            return PublicStorage::url(end($variants));
        }

        return PublicStorage::url($this->photo_path);
    }

    public function photoSrcset(): ?string
    {
        $parts = [];

        foreach (TestimonialPhotoProcessor::existingVariantPaths($this->photo_path) as $path) {
            $width = self::variantPixelWidth($path);

            if ($width === null) {
                continue;
            }

            $parts[] = PublicStorage::url($path).' '.$width.'w';
        }

        return $parts !== [] ? implode(', ', $parts) : null;
    }

    private static function variantPixelWidth(string $path): ?int
    {
        $fullPath = Storage::disk('public')->path($path);
        $dimensions = @getimagesize($fullPath);

        if ($dimensions !== false) {
            return $dimensions[0];
        }

        if (preg_match('/-(\d+)w\.webp$/', $path, $matches) === 1) {
            return (int) $matches[1];
        }

        return null;
    }

    public function photoSizes(): string
    {
        return '(min-width: 1024px) 600px, 100vw';
    }

    public function plainQuote(): string
    {
        if (blank($this->quote)) {
            return '';
        }

        $text = html_entity_decode((string) $this->quote, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::squish(strip_tags($text));
    }
}
