<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug', 'title', 'subtitle', 'content', 'blocks', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return ['blocks' => 'array'];
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
