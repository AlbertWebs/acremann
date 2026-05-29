<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Filament\Schemas\HomepageHeroVideoForm;
use App\Models\SiteSetting;
use App\Support\PublicStorage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageHomepageHeroVideo extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $navigationLabel = 'Hero video';

    protected static ?string $title = 'Homepage hero video';

    protected static ?string $slug = 'homepage-hero-video';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 6;

    protected static bool $shouldRegisterNavigation = true;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SiteSetting::current()->getKey());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! empty($data['hero_video_path'])) {
            $data['hero_video_path'] = PublicStorage::normalizePath($data['hero_video_path']);
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! ($data['hero_video_enabled'] ?? false)) {
            $data['hero_video_provider'] = null;
            $data['hero_video_url'] = null;
            $data['hero_video_path'] = null;

            return $data;
        }

        $provider = $data['hero_video_provider'] ?? null;

        if ($provider === 'upload') {
            $data['hero_video_url'] = null;
            $data['hero_video_path'] = PublicStorage::normalizePath($data['hero_video_path'] ?? null);
        } else {
            $data['hero_video_path'] = null;
            $data['hero_video_url'] = trim((string) ($data['hero_video_url'] ?? ''));
        }

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return HomepageHeroVideoForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('homepageHero')
                ->label('Homepage hero')
                ->icon(Heroicon::OutlinedHomeModern)
                ->url(ManageHomepageHero::getUrl(['record' => SiteSetting::current()])),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Hero video settings saved';
    }
}
