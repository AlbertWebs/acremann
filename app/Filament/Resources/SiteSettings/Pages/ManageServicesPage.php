<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Filament\Schemas\ServicesPageForm;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageServicesPage extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Services page intro';

    protected static ?string $title = 'Services page';

    protected static ?string $slug = 'services-page';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    public function form(Schema $schema): Schema
    {
        return ServicesPageForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('manageServices')
                ->label('Edit each service')
                ->icon(Heroicon::OutlinedBriefcase)
                ->color('primary')
                ->url(ServiceResource::getUrl('index')),
            Action::make('viewLive')
                ->label('View /services')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(route('services'), shouldOpenInNewTab: true),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Services page intro saved';
    }
}
