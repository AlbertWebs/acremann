<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsOverTimeChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Lead activity';

    protected ?string $description = 'Enquiries captured over time';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 2,
    ];

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '90' => 'Last 90 days',
            '365' => 'Last 12 months',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $days = (int) $this->filter;
        $labels = [];
        $values = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $labels[] = $days <= 14
                ? $date->format('D')
                : $date->format('M j');
            $values[] = Lead::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $values,
                    'fill' => 'start',
                    'borderColor' => '#2D4A3E',
                    'backgroundColor' => 'rgba(45, 74, 62, 0.15)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
