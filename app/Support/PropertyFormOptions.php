<?php

namespace App\Support;

class PropertyFormOptions
{
    /** @return array<string, string> */
    public static function listingStatuses(): array
    {
        return [
            'available' => 'Available',
            'reserved' => 'Reserved',
            'sold' => 'Sold',
            'coming_soon' => 'Coming soon',
        ];
    }

    /** @return array<string, string> */
    public static function projectStatuses(): array
    {
        return [
            'selling' => 'Selling',
            'launching' => 'Launching soon',
            'sold_out' => 'Sold out',
        ];
    }

    /** @return array<string, string> */
    public static function categories(): array
    {
        return [
            'residential' => 'Residential',
            'commercial' => 'Commercial',
            'mixed' => 'Mixed use',
            'agricultural' => 'Agricultural',
        ];
    }

    /** @return array<string, string> */
    public static function titleTypes(): array
    {
        return [
            'freehold' => 'Freehold',
            'leasehold' => 'Leasehold',
        ];
    }

    /** @return array<string, string> */
    public static function listingTypes(): array
    {
        return [
            'sale' => 'For sale',
            'rent' => 'For rent',
        ];
    }

    /** @return array<string, string> */
    public static function counties(): array
    {
        return [
            'Nairobi' => 'Nairobi',
            'Kiambu' => 'Kiambu',
            'Kajiado' => 'Kajiado',
            'Machakos' => 'Machakos',
            'Murang\'a' => 'Murang\'a',
            'Nakuru' => 'Nakuru',
            'Mombasa' => 'Mombasa',
            'Other' => 'Other',
        ];
    }
}
