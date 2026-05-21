<?php

namespace App\Filament\Resources\AssistantSessions\Pages;

use App\Filament\Resources\AssistantSessions\AssistantSessionResource;
use App\Filament\Resources\Leads\LeadResource;
use App\Models\AssistantSession;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ViewAssistantSession extends ViewRecord
{
    protected static string $resource = AssistantSessionResource::class;

    public function getTitle(): string | Htmlable
    {
        return $this->getRecord()->contactDisplayName();
    }

    public function getSubheading(): string | Htmlable | null
    {
        $record = $this->getRecord();

        return collect([
            $record->statusLabel(),
            $record->journeyLabel(),
            $record->event_count.' events',
            $record->last_activity_at?->diffForHumans(),
        ])->filter()->implode(' · ');
    }

    protected function getHeaderActions(): array
    {
        $record = $this->getRecord();
        $settings = SiteSetting::current();

        $actions = [
            Action::make('back')
                ->label('All conversations')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(AssistantSessionResource::getUrl('index')),
        ];

        if ($record->lead_id) {
            $actions[] = Action::make('viewLead')
                ->label('Open lead')
                ->icon(Heroicon::OutlinedInboxArrowDown)
                ->color('primary')
                ->url(LeadResource::getUrl('edit', ['record' => $record->lead_id]));
        }

        if (filled($record->phone)) {
            $actions[] = Action::make('call')
                ->label('Call')
                ->icon(Heroicon::OutlinedPhone)
                ->color('info')
                ->url('tel:'.$record->phone);
        }

        if (filled($record->email)) {
            $actions[] = Action::make('email')
                ->label('Email')
                ->icon(Heroicon::OutlinedEnvelope)
                ->color('info')
                ->url('mailto:'.$record->email);
        }

        if (filled($record->phone)) {
            $actions[] = Action::make('whatsapp')
                ->label('WhatsApp')
                ->icon(Heroicon::OutlinedChatBubbleOvalLeftEllipsis)
                ->color('success')
                ->url($settings->whatsappUrl(
                    "Hello, following up on your Acremann Assistant enquiry".($record->name ? " from {$record->name}" : '').'.'
                ))
                ->openUrlInNewTab();
        }

        if (filled($record->page_url)) {
            $actions[] = Action::make('entryPage')
                ->label('Entry page')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url($record->page_url)
                ->openUrlInNewTab();
        }

        return $actions;
    }
}
