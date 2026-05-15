<?php

namespace App\Filament\Widgets;

use App\Models\Plot;
use Filament\Widgets\ChartWidget;

class PlotAvailabilityChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Plot availability';

    protected ?string $description = 'Sold, reserved, and available plots';

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $statuses = ['available', 'reserved', 'sold'];
        $counts = collect($statuses)->mapWithKeys(fn ($status) => [
            $status => Plot::where('status', $status)->count(),
        ]);

        return [
            'datasets' => [
                [
                    'data' => $counts->values()->all(),
                    'backgroundColor' => ['#2D4A3E', '#B8956B', '#9CA3AF'],
                ],
            ],
            'labels' => $counts->keys()->map(fn ($s) => ucfirst($s))->all(),
        ];
    }
}
