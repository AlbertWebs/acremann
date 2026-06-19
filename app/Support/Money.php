<?php

namespace App\Support;

class Money
{
    public static function formatKes(float|int|string|null $amount, int $decimals = 0): string
    {
        if ($amount === null || $amount === '') {
            return '';
        }

        return number_format((float) $amount, $decimals);
    }

    public static function formatKesPrefixed(float|int|string|null $amount, int $decimals = 0): string
    {
        $formatted = self::formatKes($amount, $decimals);

        return $formatted !== '' ? 'KES '.$formatted : '';
    }

    public static function formatPropertyPrice(
        float|int|string|null $priceFrom,
        ?string $priceLabel = null,
        string $fallback = 'Contact for pricing',
    ): string {
        if (filled($priceLabel)) {
            return self::normalizePriceLabel($priceLabel);
        }

        if (filled($priceFrom)) {
            return self::formatKesPrefixed($priceFrom);
        }

        return $fallback;
    }

    /**
     * Adds thousands separators to bare numeric amounts in display labels.
     */
    public static function normalizePriceLabel(string $label): string
    {
        return preg_replace_callback(
            '/\b(\d{4,})\b/',
            fn (array $matches): string => self::formatKes($matches[1]),
            $label,
        ) ?? $label;
    }
}
