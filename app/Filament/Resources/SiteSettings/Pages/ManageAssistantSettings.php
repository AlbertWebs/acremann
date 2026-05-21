<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Schemas\AssistantSettingsForm;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageAssistantSettings extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Assistant content';

    protected static ?string $title = 'Assistant content';

    protected static ?string $slug = 'assistant-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Acremann Assistant';

    protected static ?int $navigationSort = 5;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return AssistantSettingsForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Assistant content saved';
    }
}
