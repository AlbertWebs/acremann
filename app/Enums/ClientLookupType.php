<?php

namespace App\Enums;

enum ClientLookupType: string
{
    case Title = 'title';
    case Payment = 'payment';

    public function label(): string
    {
        return match ($this) {
            self::Title => 'Title status',
            self::Payment => 'Payment status',
        };
    }
}
