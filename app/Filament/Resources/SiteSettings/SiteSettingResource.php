<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\Invest\Pages\ManageInvestIntro;
use App\Filament\Resources\SiteSettings\Pages\ManageAssistantSettings;
use App\Filament\Resources\SiteSettings\Pages\ManageHomepageHero;
use App\Filament\Resources\SiteSettings\Pages\ManageServicesPage;
use App\Filament\Resources\SiteSettings\Pages\ManageSiteSetting;
use App\Filament\Resources\SiteSettings\Schemas\SiteSettingForm;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $modelLabel = 'Site Settings';

    protected static ?string $slug = 'site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return SiteSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSiteSetting::route('/'),
            'hero' => ManageHomepageHero::route('/hero'),
            'invest-intro' => ManageInvestIntro::route('/invest-intro'),
            'assistant' => ManageAssistantSettings::route('/assistant-content'),
            'services-page' => ManageServicesPage::route('/services-page'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        return static::getUrl('index');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
