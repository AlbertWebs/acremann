<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        return PublicStorage::url($this->photo_path);
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
