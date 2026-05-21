<?php

namespace App\Filament\Resources\Leads\Pages;

use App\Filament\Resources\Leads\LeadResource;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ListInvestLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected static ?string $navigationLabel = 'Investment enquiries';

    protected static ?string $title = 'Investment enquiries';

    protected static ?string $slug = 'invest';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 5;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Leads submitted from the investment enquiry form on /invest#advisory.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->where('source', 'invest');
    }
}
