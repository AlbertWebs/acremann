<?php

namespace App\Filament\Resources\Legal\Pages;

use App\Filament\Resources\Legal\LegalPagesResource;
use App\Filament\Schemas\LegalPageForm;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManagePrivacyPage extends EditRecord
{
    protected static string $resource = LegalPagesResource::class;

    protected static ?string $navigationLabel = 'Privacy policy';

    protected static ?string $title = 'Privacy policy';

    protected static ?string $slug = 'privacy';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Legal Pages';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        $page = Page::query()->firstOrCreate(
            ['slug' => 'privacy'],
            [
                'title' => 'Privacy Notice',
                'content' => '<p>Acremann Properties collects personal data when you submit enquiries, subscribe to our newsletter, or use our client portal. We use this data to respond to your requests, improve our services, and — with consent — send marketing communications. You may request access, correction, or deletion of your data by contacting <a href="mailto:info@acremannproperties.com">info@acremannproperties.com</a>. We retain data only as long as necessary for these purposes.</p>',
            ],
        );

        parent::mount($page->getKey());
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return LegalPageForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewPrivacy')
                ->label('View live page')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => route('privacy'), shouldOpenInNewTab: true),
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
            ->title('Privacy policy saved')
            ->body('Your changes are now live on /privacy.')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->duration(6000);
    }
}
