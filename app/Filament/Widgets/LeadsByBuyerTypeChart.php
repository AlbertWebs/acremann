<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsByBuyerTypeChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Leads by buyer type';

    protected ?string $description = 'End-users, investors, diaspora & more';

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $types = Lead::query()
            ->selectRaw("coalesce(nullif(buyer_type, ''), 'unspecified') as buyer_type, count(*) as total")
            ->groupBy('buyer_type')
            ->orderByDesc('total')
            ->pluck('total', 'buyer_type');

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $types->values()->all(),
                    'backgroundColor' => '#2D4A3E',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $types->keys()->map(fn ($t) => str($t)->headline())->all(),
        ];
    }
}
