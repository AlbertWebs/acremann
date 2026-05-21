<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ListInvestServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $navigationLabel = 'Services';

    protected static ?string $title = 'Services';

    protected static ?string $slug = 'for-invest';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 7;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Advisory services referenced from audience cards and CTAs on /invest.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
