<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;

class PropertiesByCountyChart extends ChartWidget
{
    protected static ?int $sort = 6;

    protected ?string $heading = 'Properties by county';

    protected ?string $description = 'Geographic distribution of listings';

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): ?array
    {
        return [
            'indexAxis' => 'y',
        ];
    }

    protected function getData(): array
    {
        $counties = Property::query()
            ->where('is_published', true)
            ->whereNotNull('county')
            ->selectRaw('county, count(*) as total')
            ->groupBy('county')
            ->orderByDesc('total')
            ->pluck('total', 'county');

        return [
            'datasets' => [
                [
                    'label' => 'Properties',
                    'data' => $counties->values()->all(),
                    'backgroundColor' => '#B8956B',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $counties->keys()->all(),
        ];
    }
}
