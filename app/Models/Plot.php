<?php

namespace App\Models;

use App\Support\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plot extends Model
{
    protected $fillable = ['property_id', 'plot_number', 'status', 'size', 'price'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function formattedPrice(): string
    {
        return filled($this->price)
            ? Money::formatKesPrefixed($this->price)
            : '—';
    }
}
