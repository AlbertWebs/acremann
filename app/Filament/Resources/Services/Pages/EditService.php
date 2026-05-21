<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewLive')
                ->label('View live page')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => route('services.show', $this->getRecord()->slug), shouldOpenInNewTab: true)
                ->visible(fn (): bool => filled($this->getRecord()->slug) && $this->getRecord()->is_published),
            DeleteAction::make(),
        ];
    }
}
