<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Resources\Properties\Concerns\SyncsPropertyMediaForm;
use App\Filament\Resources\Properties\PropertyResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditProperty extends EditRecord
{
    use SyncsPropertyMediaForm;

    protected static string $resource = PropertyResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit property';
    }

    public function getSubheading(): string|Htmlable|null
    {
        $property = $this->getRecord();

        $parts = array_filter([
            $property->location,
            $property->county,
            $property->formattedPrice(),
            $property->is_published ? null : 'Draft',
        ]);

        return $parts !== [] ? implode(' · ', $parts) : null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewLive')
                ->label('View live')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('properties.show', $this->getRecord()))
                ->openUrlInNewTab(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->syncPropertyMediaAfterSave();
    }
}
