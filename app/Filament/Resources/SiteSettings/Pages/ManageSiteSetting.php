<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\Invest\Pages\ManageInvestPage;
use App\Filament\Resources\SiteSettings\Pages\ManageAssistantSettings;
use App\Filament\Resources\SiteSettings\Pages\ManageHomepageHero;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class ManageSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Your public identity, contact channels, page copy, and analytics — organised in tabs below.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('investPage')
                ->label('Invest page')
                ->icon(Heroicon::OutlinedChartBarSquare)
                ->color('gray')
                ->url(ManageInvestPage::getUrl()),
            Action::make('homepageHero')
                ->label('Homepage hero')
                ->icon(Heroicon::OutlinedHomeModern)
                ->color('gray')
                ->url(ManageHomepageHero::getUrl()),
            Action::make('assistantContent')
                ->label('Assistant')
                ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                ->color('gray')
                ->url(ManageAssistantSettings::getUrl()),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getSavedNotification(): ?Notification
    {
        $section = $this->activeSettingsTabLabel();
        $title = $section
            ? "{$section} saved successfully"
            : 'Site settings saved successfully';

        return Notification::make()
            ->success()
            ->title($title)
            ->body('Your changes have been saved and are now live on the website.')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->duration(6000);
    }

    /**
     * Human-readable label for the active settings tab (from ?tab= query string).
     */
    protected function activeSettingsTabLabel(): ?string
    {
        $tabId = request()->query('tab');

        if (blank($tabId)) {
            return null;
        }

        $slug = Str::before((string) $tabId, '::');

        return match ($slug) {
            'brand' => 'Brand settings',
            'contact' => 'Contact details',
            'content' => 'Page content',
            'analytics' => 'Analytics settings',
            default => Str::headline($slug),
        };
    }
}
