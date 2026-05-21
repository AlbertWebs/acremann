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

class ManageTermsPage extends EditRecord
{
    protected static string $resource = LegalPagesResource::class;

    protected static ?string $navigationLabel = 'Terms & conditions';

    protected static ?string $title = 'Terms & conditions';

    protected static ?string $slug = 'terms';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Legal Pages';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        $page = Page::query()->firstOrCreate(
            ['slug' => 'terms'],
            [
                'title' => 'Terms and Conditions',
                'content' => '<p>These terms govern your use of the Acremann Properties website and services. By submitting an enquiry, booking a site visit, or engaging our advisory team, you agree to receive communications related to your request and to provide accurate information. Property availability, pricing, and title status are subject to verification at the time of transaction. Acremann does not guarantee outcomes of third-party searches or financing. For questions about these terms, contact <a href="mailto:info@acremannproperties.com">info@acremannproperties.com</a>.</p>',
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
            Action::make('viewTerms')
                ->label('View live page')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => route('terms'), shouldOpenInNewTab: true),
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
            ->title('Terms & conditions saved')
            ->body('Your changes are now live on /terms.')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->duration(6000);
    }
}
