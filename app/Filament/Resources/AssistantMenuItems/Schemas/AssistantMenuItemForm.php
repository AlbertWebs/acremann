<?php

namespace App\Filament\Resources\AssistantMenuItems\Schemas;

use App\Models\AssistantMenuItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class AssistantMenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required()
                    ->maxLength(120)
                    ->columnSpanFull(),
                Select::make('action')
                    ->options([
                        AssistantMenuItem::ACTION_FAQ => 'Show FAQs',
                        AssistantMenuItem::ACTION_TITLE => 'Title & process info',
                        AssistantMenuItem::ACTION_LEAD => 'Open contact form',
                        AssistantMenuItem::ACTION_WHATSAPP => 'WhatsApp link',
                        AssistantMenuItem::ACTION_LINK => 'Custom link',
                    ])
                    ->required()
                    ->live()
                    ->native(false),
                Select::make('journey')
                    ->label('Form intent (for contact form)')
                    ->options([
                        'site_visit' => 'Book a site visit',
                        'financing' => 'Pricing & financing',
                        'general' => 'General enquiry',
                    ])
                    ->visible(fn (Get $get): bool => $get('action') === AssistantMenuItem::ACTION_LEAD),
                TextInput::make('lead_form_title')
                    ->label('Form heading')
                    ->helperText('Shown at the top of the form for this button.')
                    ->maxLength(120)
                    ->visible(fn (Get $get): bool => $get('action') === AssistantMenuItem::ACTION_LEAD),
                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->maxLength(500)
                    ->helperText('Required for custom links. Optional override for other types.')
                    ->visible(fn (Get $get): bool => in_array($get('action'), [
                        AssistantMenuItem::ACTION_LINK,
                        AssistantMenuItem::ACTION_WHATSAPP,
                    ], true)),
                Toggle::make('open_in_new_tab')
                    ->label('Open in new tab')
                    ->default(true)
                    ->visible(fn (Get $get): bool => in_array($get('action'), [
                        AssistantMenuItem::ACTION_LINK,
                        AssistantMenuItem::ACTION_WHATSAPP,
                    ], true)),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('Published')
                    ->default(true)
                    ->required(),
            ]);
    }
}
