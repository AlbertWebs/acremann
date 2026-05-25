<?php

namespace App\Filament\Resources\SiteVisitBookings;

use App\Filament\Resources\SiteVisitBookings\Pages\EditSiteVisitBooking;
use App\Filament\Resources\SiteVisitBookings\Pages\ListSiteVisitBookings;
use App\Filament\Resources\SiteVisitBookings\Schemas\SiteVisitBookingForm;
use App\Filament\Resources\SiteVisitBookings\Tables\SiteVisitBookingsTable;
use App\Models\SiteVisitBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SiteVisitBookingResource extends Resource
{
    protected static ?string $model = SiteVisitBooking::class;

    protected static ?string $navigationLabel = 'Site visit bookings';

    protected static ?string $modelLabel = 'booking';

    protected static ?string $pluralModelLabel = 'site visit bookings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SiteVisitBookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteVisitBookingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteVisitBookings::route('/'),
            'edit' => EditSiteVisitBooking::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
