<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    protected $fillable = [
        'name', 'role', 'bio', 'photo_path', 'is_leadership', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_leadership' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
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
}
