<?php

namespace App\Filament\Resources\SiteVisitBookings\Pages;

use App\Enums\SiteVisitBookingStatus;
use App\Filament\Resources\SiteVisitBookings\SiteVisitBookingResource;
use App\Services\SiteVisitBookingService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSiteVisitBooking extends EditRecord
{
    protected static string $resource = SiteVisitBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->label('Mark confirmed')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => $this->record->status === SiteVisitBookingStatus::Pending)
                ->requiresConfirmation()
                ->action(fn () => $this->transitionStatus(SiteVisitBookingStatus::Confirmed)),
            Action::make('complete')
                ->label('Mark completed')
                ->icon('heroicon-o-flag')
                ->color('info')
                ->visible(fn (): bool => in_array($this->record->status, [SiteVisitBookingStatus::Pending, SiteVisitBookingStatus::Confirmed], true))
                ->requiresConfirmation()
                ->action(fn () => $this->transitionStatus(SiteVisitBookingStatus::Completed)),
            Action::make('cancel')
                ->label('Cancel booking')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (): bool => $this->record->status !== SiteVisitBookingStatus::Cancelled)
                ->requiresConfirmation()
                ->action(fn () => $this->transitionStatus(SiteVisitBookingStatus::Cancelled)),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('status')) {
            if ($this->record->status !== SiteVisitBookingStatus::Pending && blank($this->record->processed_at)) {
                $this->record->update(['processed_at' => now()]);
            }

            app(SiteVisitBookingService::class)->notifyStatusChange($this->record);
        }

        Notification::make()
            ->title('Booking updated')
            ->success()
            ->send();
    }

    protected function transitionStatus(SiteVisitBookingStatus $status): void
    {
        app(SiteVisitBookingService::class)->updateStatus($this->record, $status);

        $this->record->refresh();
        $this->fillForm();

        Notification::make()
            ->title('Status: '.$status->label())
            ->success()
            ->send();
    }
}
