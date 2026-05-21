<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ListFeaturedProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected static ?string $navigationLabel = 'Featured properties';

    protected static ?string $title = 'Featured properties';

    protected static ?string $slug = 'featured';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Listings marked as featured appear in the “Featured investment properties” section on /invest. Full create and edit actions are available here.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return Property::query()->where('is_featured', true);
    }
}
