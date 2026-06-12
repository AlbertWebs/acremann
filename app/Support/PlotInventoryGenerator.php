<?php

namespace App\Support;

use App\Models\Property;
use Illuminate\Support\Facades\DB;

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

    /**
     * @return array{total: int, sold: int, reserved: int, available: int}|null
     */
    public static function resolveCounts(int $total, int $sold, int $reserved = 0): ?array
    {
        $total = max(0, $total);
        $sold = max(0, $sold);
        $reserved = max(0, $reserved);

        if ($total === 0) {
            return null;
        }

        if ($sold + $reserved > $total) {
            return null;
        }

        return [
            'total' => $total,
            'sold' => $sold,
            'reserved' => $reserved,
            'available' => $total - $sold - $reserved,
        ];
    }

    public static function padLengthForTotal(int $total, int $startNumber, string $prefix): int
    {
        if ($prefix === '') {
            return 0;
        }

        $highestNumber = max(1, $startNumber + max(0, $total) - 1);

        return max(2, strlen((string) $highestNumber));
    }

    /**
     * Replace all plots for a property in the database.
     *
     * @return array{total: int, sold: int, reserved: int, available: int}|null
     */
    public static function replaceForProperty(
        Property $property,
        int $total,
        int $sold,
        int $reserved = 0,
        string $prefix = 'A',
        int $startNumber = 1,
        ?string $defaultSize = null,
        ?string $defaultPrice = null,
    ): ?array {
        $counts = static::resolveCounts($total, $sold, $reserved);

        if ($counts === null) {
            return null;
        }

        $padLength = static::padLengthForTotal($counts['total'], $startNumber, $prefix);
        $plotRows = static::generate(
            available: $counts['available'],
            sold: $counts['sold'],
            reserved: $counts['reserved'],
            prefix: $prefix,
            startNumber: $startNumber,
            padLength: $padLength,
            defaultSize: $defaultSize,
            defaultPrice: $defaultPrice,
        );

        DB::transaction(function () use ($property, $plotRows): void {
            $property->plots()->delete();

            foreach ($plotRows as $row) {
                $property->plots()->create($row);
            }
        });

        $property->unsetRelation('plots');

        return $counts;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function formStateForProperty(Property $property): array
    {
        return $property->plots()
            ->orderBy('id')
            ->get()
            ->map(fn ($plot): array => [
                'id' => $plot->id,
                'plot_number' => $plot->plot_number,
                'status' => $plot->status,
                'size' => $plot->size,
                'price' => $plot->price,
            ])
            ->all();
    }
}
