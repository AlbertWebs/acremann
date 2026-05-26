<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\Concerns\SyncsEventMediaForm;
use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    use SyncsEventMediaForm;

    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewLive')
                ->label('View live')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('events.show', $this->getRecord()))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->syncEventMediaAfterSave();
    }
}
