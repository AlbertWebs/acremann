<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsBySourceChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Leads by source';

    protected ?string $description = 'Where enquiries originate';

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $sources = Lead::query()
            ->selectRaw('source, count(*) as total')
            ->groupBy('source')
            ->orderByDesc('total')
            ->pluck('total', 'source');

        $colors = [
            '#2D4A3E',
            '#FBB13A',
            '#4A6B5D',
            '#8B7355',
            '#1A1A18',
            '#6B8F7A',
        ];

        return [
            'datasets' => [
                [
                    'data' => $sources->values()->all(),
                    'backgroundColor' => array_slice($colors, 0, $sources->count()),
                ],
            ],
            'labels' => $sources->keys()->map(fn ($s) => str($s)->headline())->all(),
        ];
    }
}
