<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'preferences', 'consent_marketing'];

    protected function casts(): array
    {
        return [
            'preferences' => 'array',
            'consent_marketing' => 'boolean',
        ];
    }
}
