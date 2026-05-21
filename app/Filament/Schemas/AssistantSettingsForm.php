<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssistantSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Widget header')
                    ->schema([
                        TextInput::make('assistant_heading')
                            ->label('Title')
                            ->placeholder('Acremann Assistant')
                            ->maxLength(120),
                        TextInput::make('assistant_subheading')
                            ->label('Subtitle')
                            ->placeholder('How can we help you today?')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Title & process screen')
                    ->schema([
                        Textarea::make('assistant_title_body')
                            ->label('Body text')
                            ->rows(5)
                            ->columnSpanFull(),
                        TextInput::make('assistant_title_link_label')
                            ->label('Link label')
                            ->placeholder('View all FAQs →'),
                        TextInput::make('assistant_title_link_url')
                            ->label('Link URL')
                            ->placeholder('/faqs')
                            ->helperText('Relative path or full URL.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Lead form')
                    ->schema([
                        TextInput::make('assistant_whatsapp_label')
                            ->label('WhatsApp button label (menu)')
                            ->placeholder('Chat on WhatsApp'),
                        Textarea::make('assistant_consent_text')
                            ->label('Consent checkbox text')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('assistant_success_message')
                            ->label('Thank-you message')
                            ->placeholder("Thank you! We'll be in touch.")
                            ->columnSpanFull(),
                        Repeater::make('assistant_buyer_types')
                            ->label('Buyer type options')
                            ->schema([
                                TextInput::make('value')->required()->maxLength(50),
                                TextInput::make('label')->required()->maxLength(120),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->columnSpanFull(),
                        Repeater::make('assistant_budget_ranges')
                            ->label('Budget range options')
                            ->schema([
                                TextInput::make('value')->required()->maxLength(50),
                                TextInput::make('label')->required()->maxLength(120),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
