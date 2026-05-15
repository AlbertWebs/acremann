<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\Plot;
use App\Models\Property;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AcremannStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Overview';

    protected ?string $description = 'Key metrics across properties, leads, and engagement';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $leadsTotal = Lead::count();
        $leadsNew = Lead::where('created_at', '>=', now()->subDays(30))->count();
        $leadsPrevious = Lead::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $leadsTrend = $leadsPrevious > 0
            ? round((($leadsNew - $leadsPrevious) / $leadsPrevious) * 100)
            : ($leadsNew > 0 ? 100 : 0);

        $plotsAvailable = Plot::where('status', 'available')->count();
        $plotsTotal = Plot::count();
        $plotsSold = Plot::where('status', 'sold')->count();

        return [
            Stat::make('Published properties', Property::where('is_published', true)->count())
                ->description(Property::where('is_featured', true)->count().' featured')
                ->descriptionIcon(Heroicon::OutlinedBuildingOffice2)
                ->color('primary')
                ->icon(Heroicon::OutlinedHomeModern)
                ->url(PropertyResource::getUrl('index'))
                ->chart([7, 4, 5, 6, 8, Property::count()]),

            Stat::make('Total leads', $leadsTotal)
                ->description($leadsNew.' in last 30 days')
                ->descriptionIcon($leadsTrend >= 0 ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                ->descriptionColor($leadsTrend >= 0 ? 'success' : 'danger')
                ->color('success')
                ->icon(Heroicon::OutlinedUserGroup)
                ->url(LeadResource::getUrl('index'))
                ->chart($this->leadSparkline()),

            Stat::make('New leads (30d)', $leadsNew)
                ->description(($leadsTrend >= 0 ? '+' : '').$leadsTrend.'% vs prior 30 days')
                ->descriptionColor($leadsTrend >= 0 ? 'success' : 'danger')
                ->color('warning')
                ->icon(Heroicon::OutlinedInboxArrowDown),

            Stat::make('Plots available', $plotsAvailable)
                ->description($plotsSold.' sold · '.$plotsTotal.' total')
                ->color('info')
                ->icon(Heroicon::OutlinedMap)
                ->url(PropertyResource::getUrl('index')),

            Stat::make('Newsletter subscribers', NewsletterSubscriber::count())
                ->description('Marketing opt-ins')
                ->color('gray')
                ->icon(Heroicon::OutlinedEnvelope)
                ->url(NewsletterSubscriberResource::getUrl('index')),

            Stat::make('Pending follow-ups', Lead::where('status', 'new')->count())
                ->description('Leads awaiting contact')
                ->color('danger')
                ->icon(Heroicon::OutlinedBellAlert)
                ->url(LeadResource::getUrl('index')),
        ];
    }

    /**
     * @return array<int, int>
     */
    protected function leadSparkline(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $data[] = Lead::whereDate('created_at', now()->subDays($i))->count();
        }

        return $data;
    }
}
