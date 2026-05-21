<?php

namespace App\Filament\Resources\Certifications\Pages;

use App\Filament\Resources\Certifications\CertificationResource;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ListInvestCertifications extends ListRecords
{
    protected static string $resource = CertificationResource::class;

    protected static ?string $navigationLabel = 'Certifications';

    protected static ?string $title = 'Certifications';

    protected static ?string $slug = 'for-invest';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Invest';

    protected static ?int $navigationSort = 6;

    protected static bool $shouldRegisterNavigation = true;

    public function getSubheading(): ?string
    {
        return 'Credentials linked from the invest page (“Review our credentials”).';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
