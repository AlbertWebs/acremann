<?php

namespace App\Filament\Resources\Invest\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Filament\Schemas\InvestIntroForm;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageInvestIntro extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Hero intro';

    protected static ?string $title = 'Invest hero intro';

    protected static ?string $slug = 'invest-intro';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return InvestIntroForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewInvest')
                ->label('View live page')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => route('invest'), shouldOpenInNewTab: true),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Hero intro saved successfully')
            ->body('The introduction under the invest page title has been updated.')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->duration(6000);
    }
}
