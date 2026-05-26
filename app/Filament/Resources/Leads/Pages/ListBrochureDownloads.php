<?php

namespace App\Filament\Resources\Leads\Pages;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Leads\Tables\BrochureDownloadsTable;
use BackedEnum;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ListBrochureDownloads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected static ?string $navigationLabel = 'Brochure downloads';

    protected static ?string $title = 'Brochure downloads';

    protected static ?string $slug = 'brochure-downloads';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Contact details submitted via the “Download brochure” form on property pages.';
    }

    public function table(Table $table): Table
    {
        return BrochureDownloadsTable::configure($table);
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->where('source', 'brochure_download');
    }
}
