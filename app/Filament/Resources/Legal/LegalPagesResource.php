<?php

namespace App\Filament\Resources\Legal;

use App\Filament\Resources\Legal\Pages\ManagePrivacyPage;
use App\Filament\Resources\Legal\Pages\ManageTermsPage;
use App\Models\Page;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Pages\Page as ResourcePage;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LegalPagesResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationLabel = 'Legal pages';

    protected static ?string $modelLabel = 'legal page';

    protected static ?string $pluralModelLabel = 'legal pages';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = 'Legal Pages';

    protected static ?int $navigationSort = 0;

    protected static bool $shouldRegisterNavigation = false;

    public static function registerNavigationItems(): void
    {
        if (filled(static::getCluster()) || ! static::canAccess()) {
            return;
        }

        $items = [];

        foreach (static::getNavigationPages() as $page) {
            if (! static::shouldRegisterPageNavigation($page)) {
                continue;
            }

            $items = [...$items, ...$page::getNavigationItems()];
        }

        if ($items === []) {
            return;
        }

        Filament::getCurrentOrDefaultPanel()->navigationItems($items);
    }

    /**
     * @return array<class-string<ResourcePage>>
     */
    protected static function getNavigationPages(): array
    {
        return [
            ManagePrivacyPage::class,
            ManageTermsPage::class,
        ];
    }

    /**
     * @param  class-string<ResourcePage>  $page
     */
    protected static function shouldRegisterPageNavigation(string $page): bool
    {
        if (! $page::canAccess()) {
            return false;
        }

        if (is_subclass_of($page, \Filament\Resources\Pages\EditRecord::class)) {
            return (new \ReflectionClass($page))->getStaticPropertyValue('shouldRegisterNavigation');
        }

        return $page::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
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
            'privacy' => ManagePrivacyPage::route('/privacy'),
            'terms' => ManageTermsPage::route('/terms'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
