<?php

namespace App\Filament\Resources\Invest;

use App\Filament\Resources\Certifications\Pages\ListInvestCertifications;
use App\Filament\Resources\Invest\Pages\ManageInvestIntro;
use App\Filament\Resources\Invest\Pages\ManageInvestPage;
use App\Filament\Resources\Leads\Pages\ListInvestLeads;
use App\Filament\Resources\Properties\Pages\ListFeaturedProperties;
use App\Filament\Resources\Services\Pages\ListInvestServices;
use App\Filament\Resources\Testimonials\Pages\ListInvestTestimonials;
use App\Models\Page;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Pages\Page as ResourcePage;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InvestResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationLabel = 'Invest';

    protected static ?string $modelLabel = 'Invest page';

    protected static ?string $slug = 'invest';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

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
            ManageInvestPage::class,
            ManageInvestIntro::class,
            ListFeaturedProperties::class,
            ListInvestTestimonials::class,
            ListInvestLeads::class,
            ListInvestCertifications::class,
            ListInvestServices::class,
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
            'index' => ManageInvestPage::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
