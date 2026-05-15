<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'source', 'name', 'email', 'phone', 'property_id', 'buyer_type', 'budget',
        'location_preference', 'property_interest', 'message', 'metadata',
        'consent_callback', 'consent_whatsapp', 'consent_email', 'consent_marketing', 'status',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'consent_callback' => 'boolean',
            'consent_whatsapp' => 'boolean',
            'consent_email' => 'boolean',
            'consent_marketing' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
