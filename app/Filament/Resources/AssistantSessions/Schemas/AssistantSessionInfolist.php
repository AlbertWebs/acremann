<?php

namespace App\Filament\Resources\AssistantSessions\Schemas;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\AssistantSession;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AssistantSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('At a glance')
                    ->icon(Heroicon::OutlinedChartBarSquare)
                    ->columns(4)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(fn ($state, AssistantSession $record): string => $record->statusLabel())
                            ->color(fn ($state, AssistantSession $record): string => $record->statusColor()),
                        TextEntry::make('journey')
                            ->label('Intent')
                            ->icon(Heroicon::OutlinedFlag)
                            ->formatStateUsing(fn ($state, AssistantSession $record): string => $record->journeyLabel()),
                        TextEntry::make('event_count')
                            ->label('Events')
                            ->icon(Heroicon::OutlinedListBullet)
                            ->numeric(),
                        TextEntry::make('last_activity_at')
                            ->label('Last active')
                            ->icon(Heroicon::OutlinedClock)
                            ->since()
                            ->dateTimeTooltip(),
                    ])
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        Section::make('Conversation')
                            ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                            ->description(function (AssistantSession $record): string {
                                $parts = [
                                    $record->event_count.' interaction'.($record->event_count === 1 ? '' : 's'),
                                ];
                                if ($record->started_at) {
                                    $parts[] = 'started '.$record->started_at->diffForHumans();
                                }

                                return implode(' · ', $parts);
                            })
                            ->schema([
                                ViewEntry::make('transcript_timeline')
                                    ->hiddenLabel()
                                    ->view('filament.assistant-sessions.transcript-timeline'),
                            ])
                            ->columnSpan(2),
                        Grid::make(1)
                            ->schema([
                                Section::make('Contact')
                                    ->icon(Heroicon::OutlinedUser)
                                    ->description(fn (AssistantSession $record): ?string => $record->hasContactDetails()
                                        ? null
                                        : 'Visitor has not shared contact details yet.')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->icon(Heroicon::OutlinedUserCircle)
                                            ->placeholder('Not provided'),
                                        TextEntry::make('phone')
                                            ->icon(Heroicon::OutlinedPhone)
                                            ->placeholder('Not provided')
                                            ->copyable()
                                            ->url(fn (?string $state): ?string => filled($state) ? 'tel:'.$state : null),
                                        TextEntry::make('email')
                                            ->icon(Heroicon::OutlinedEnvelope)
                                            ->placeholder('Not provided')
                                            ->copyable()
                                            ->url(fn (?string $state): ?string => filled($state) ? 'mailto:'.$state : null),
                                        TextEntry::make('buyer_type')
                                            ->label('Buyer type')
                                            ->icon(Heroicon::OutlinedIdentification)
                                            ->formatStateUsing(fn (?string $state): string => AssistantSession::formatBuyerType($state)),
                                        TextEntry::make('budget')
                                            ->icon(Heroicon::OutlinedBanknotes)
                                            ->formatStateUsing(fn (?string $state): string => AssistantSession::formatBudget($state)),
                                        TextEntry::make('message')
                                            ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                                            ->placeholder('No message')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                                Section::make('Context')
                                    ->icon(Heroicon::OutlinedGlobeAlt)
                                    ->schema([
                                        TextEntry::make('property.title')
                                            ->label('Property')
                                            ->icon(Heroicon::OutlinedBuildingOffice2)
                                            ->placeholder('—'),
                                        TextEntry::make('last_step')
                                            ->label('Last step')
                                            ->icon(Heroicon::OutlinedArrowRightCircle)
                                            ->placeholder('—')
                                            ->formatStateUsing(fn (?string $state): string => $state ? ucfirst(str_replace('_', ' ', $state)) : '—'),
                                        TextEntry::make('lead_id')
                                            ->label('Linked lead')
                                            ->icon(Heroicon::OutlinedInboxArrowDown)
                                            ->formatStateUsing(fn (?int $state): string => $state ? "Lead #{$state}" : '—')
                                            ->url(fn (AssistantSession $record): ?string => $record->lead_id
                                                ? LeadResource::getUrl('edit', ['record' => $record->lead_id])
                                                : null)
                                            ->color(fn (AssistantSession $record): ?string => $record->lead_id ? 'primary' : null),
                                        TextEntry::make('page_url')
                                            ->label('Entry page')
                                            ->icon(Heroicon::OutlinedLink)
                                            ->placeholder('—')
                                            ->url(fn (?string $state): ?string => $state)
                                            ->openUrlInNewTab()
                                            ->limit(50),
                                        TextEntry::make('session_id')
                                            ->label('Session ID')
                                            ->icon(Heroicon::OutlinedFingerPrint)
                                            ->copyable()
                                            ->size('sm'),
                                    ])
                                    ->columns(1),
                                Section::make('Technical')
                                    ->icon(Heroicon::OutlinedCpuChip)
                                    ->collapsed()
                                    ->schema([
                                        TextEntry::make('started_at')
                                            ->dateTime()
                                            ->placeholder('—'),
                                        TextEntry::make('ip_address')
                                            ->label('IP address')
                                            ->placeholder('—'),
                                        TextEntry::make('user_agent')
                                            ->label('Browser / device')
                                            ->placeholder('—')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
