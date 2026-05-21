<?php

namespace App\Filament\Resources\Invest\Pages;

use App\Filament\Resources\Invest\InvestResource;
use App\Filament\Schemas\InvestPageForm;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageInvestPage extends EditRecord
{
    protected static string $resource = InvestResource::class;

    protected static ?string $navigationLabel = 'Invest page';

    protected static ?string $title = 'Invest page';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        $page = Page::query()->firstOrCreate(
            ['slug' => 'invest'],
            [
                'title' => 'Why Invest With Acremann',
                'subtitle' => 'Future-focused land investment',
                'content' => '<p>Land remains one of Kenya\'s most resilient asset classes. Acremann combines legal precision, financial discipline, and sustainability thinking to protect your investment.</p>',
            ],
        );

        parent::mount($page->getKey());
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return InvestPageForm::configure($schema);
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
            ->title('Invest page saved successfully')
            ->body('Your changes are now live on /invest.')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->duration(6000);
    }
}
