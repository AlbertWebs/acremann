<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TeamMember extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'role', 'bio', 'photo_path', 'is_leadership', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_leadership' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function scopeLeadership($query)
    {
        return $query->where('is_leadership', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function photoUrl(): ?string
    {
        return PublicStorage::url($this->photo_path);
    }

    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn (string $word): string => strtoupper(Str::substr($word, 0, 1)))
            ->take(2)
            ->join('');
    }

    public function plainBio(): string
    {
        if (blank($this->bio)) {
            return '';
        }

        $text = html_entity_decode($this->bio, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::squish(strip_tags($text));
    }

    public function seoTitle(): string
    {
        return "{$this->name} — {$this->role}";
    }

    public function seoDescription(): string
    {
        $company = SiteSetting::current()->company_name ?: 'Acremann Properties';
        $lead = "{$this->name}, {$this->role} at {$company}.";

        $bio = $this->plainBio();
        if ($bio === '') {
            return Str::limit("{$lead} Leadership profile at Acremann Properties — verified land and real estate advisory in Kenya.", 160, '');
        }

        return Str::limit("{$lead} {$bio}", 160, '');
    }

    public function seoImageUrl(): ?string
    {
        $photo = $this->photoUrl();

        return $photo ? url($photo) : null;
    }
}
