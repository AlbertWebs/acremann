<?php

namespace App\Models;

use App\Enums\SiteVisitBookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteVisitBooking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'property_id',
        'buyer_type',
        'budget',
        'property_interest',
        'message',
        'consent_callback',
        'consent_whatsapp',
        'consent_email',
        'consent_marketing',
        'status',
        'admin_notes',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => SiteVisitBookingStatus::class,
            'consent_callback' => 'boolean',
            'consent_whatsapp' => 'boolean',
            'consent_email' => 'boolean',
            'consent_marketing' => 'boolean',
            'processed_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function isPending(): bool
    {
        return $this->status === SiteVisitBookingStatus::Pending;
    }
}
