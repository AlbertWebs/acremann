<?php

namespace App\Filament\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InvestIntroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero introduction')
                    ->description('Short paragraph under the page title on /invest. Plain text is shown on the site (HTML tags are stripped).')
                    ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                    ->schema([
                        FormComponents::richEditor('investment_intro')
                            ->label('Introduction')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
