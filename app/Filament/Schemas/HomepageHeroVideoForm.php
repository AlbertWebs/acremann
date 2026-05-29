<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class HomepageHeroVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero video')
                    ->description('Replace the large hero image (top-left of the media grid) with a background-style video. Requires “Custom hero images” on Homepage Hero. Smaller slots still use uploaded hero images.')
                    ->schema([
                        Toggle::make('hero_video_enabled')
                            ->label('Show video in large hero slot')
                            ->default(false)
                            ->live()
                            ->columnSpanFull(),
                        Select::make('hero_video_provider')
                            ->label('Video source')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                                'upload' => 'Upload MP4',
                            ])
                            ->default('youtube')
                            ->required(fn (Get $get): bool => (bool) $get('hero_video_enabled'))
                            ->live()
                            ->visible(fn (Get $get): bool => (bool) $get('hero_video_enabled'))
                            ->columnSpanFull(),
                        TextInput::make('hero_video_url')
                            ->label('YouTube or Vimeo URL')
                            ->placeholder('https://www.youtube.com/watch?v=… or https://vimeo.com/…')
                            ->url()
                            ->maxLength(500)
                            ->helperText('Paste the full share or watch link from YouTube or Vimeo.')
                            ->visible(fn (Get $get): bool => (bool) $get('hero_video_enabled') && in_array($get('hero_video_provider'), ['youtube', 'vimeo'], true))
                            ->required(fn (Get $get): bool => (bool) $get('hero_video_enabled') && in_array($get('hero_video_provider'), ['youtube', 'vimeo'], true))
                            ->columnSpanFull(),
                        FileUpload::make('hero_video_path')
                            ->label('MP4 video file')
                            ->acceptedFileTypes(['video/mp4'])
                            ->directory('hero/videos')
                            ->disk('public')
                            ->maxSize(51200)
                            ->helperText('MP4 only, max 50 MB. Landscape 16:9 works best for the wide hero slot.')
                            ->visible(fn (Get $get): bool => (bool) $get('hero_video_enabled') && $get('hero_video_provider') === 'upload')
                            ->required(fn (Get $get): bool => (bool) $get('hero_video_enabled') && $get('hero_video_provider') === 'upload')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
