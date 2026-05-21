<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['category', 'question', 'answer', 'sort_order', 'is_published', 'show_in_assistant'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'show_in_assistant' => 'boolean',
        ];
    }

    public function scopeForAssistant($query)
    {
        return $query->where('is_published', true)
            ->where('show_in_assistant', true)
            ->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
