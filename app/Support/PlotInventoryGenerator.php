<?php

namespace App\Support;

class PlotInventoryGenerator
{
    /**
     * @return array<int, array{plot_number: string, status: string, size: ?string, price: ?string}>
     */
    public static function generate(
        int $available,
        int $sold,
        int $reserved = 0,
        string $prefix = '',
        int $startNumber = 1,
        int $padLength = 2,
        ?string $defaultSize = null,
        ?string $defaultPrice = null,
    ): array {
        $statuses = array_merge(
            array_fill(0, max(0, $sold), 'sold'),
            array_fill(0, max(0, $reserved), 'reserved'),
            array_fill(0, max(0, $available), 'available'),
        );

        $plots = [];

        foreach ($statuses as $index => $status) {
            $plots[] = [
                'plot_number' => static::formatPlotNumber($prefix, $startNumber + $index, $padLength),
                'status' => $status,
                'size' => $defaultSize,
                'price' => $defaultPrice,
            ];
        }

        return $plots;
    }

    public static function formatPlotNumber(string $prefix, int $number, int $padLength): string
    {
        $formatted = $padLength > 0
            ? str_pad((string) $number, $padLength, '0', STR_PAD_LEFT)
            : (string) $number;

        return $prefix.$formatted;
    }

    public static function total(int $available, int $sold, int $reserved = 0): int
    {
        return max(0, $available) + max(0, $sold) + max(0, $reserved);
    }
}
