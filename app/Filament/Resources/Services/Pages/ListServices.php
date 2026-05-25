<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\SiteSettings\Pages\ManageServicesPage;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    public function getSubheading(): ?string
    {
        return 'Each row is a card on /services. Upload a featured image for the grid and a header image for the detail page hero. Edit title, summary, and full page content below.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('servicesPageIntro')
                ->label('Services page intro')
                ->icon(Heroicon::OutlinedDocumentText)
                ->color('gray')
                ->url(ManageServicesPage::getUrl(['record' => SiteSetting::current()])),
            Action::make('viewServices')
                ->label('View /services')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(route('services.index'), shouldOpenInNewTab: true),
            CreateAction::make(),
        ];
    }
}
