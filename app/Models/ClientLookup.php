<?php

namespace App\Models;

use App\Enums\ClientLookupType;
use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Model;

class ClientLookup extends Model
{
    protected $fillable = [
        'reference_number',
        'lookup_type',
        'client_name',
        'client_phone',
        'client_email',
        'status_message',
        'statement_path',
    ];

    protected function casts(): array
    {
        return [
            'lookup_type' => ClientLookupType::class,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (ClientLookup $lookup): void {
            $lookup->reference_number = strtoupper(trim($lookup->reference_number));
            $lookup->client_email = filled($lookup->client_email)
                ? strtolower(trim($lookup->client_email))
                : null;
            $lookup->client_phone = self::normalizePhone($lookup->client_phone);
        });
    }

    public function statementUrl(): ?string
    {
        return PublicStorage::url($this->statement_path);
    }

    public function hasStatement(): bool
    {
        return filled($this->statement_path);
    }

    public function requiresIdentityCheck(): bool
    {
        return filled($this->client_phone) || filled($this->client_email);
    }

    public static function normalizePhone(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $phone) ?? '';

        if (str_starts_with($digits, '254') && strlen($digits) >= 12) {
            $digits = substr($digits, 3);
        }

        $digits = ltrim($digits, '0');

        return $digits !== '' ? $digits : null;
    }
}
