<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Concerns\ChecksAdminRole;
use Filament\Resources\Resource;
use UnitEnum;

/**
 * Base resource for finance-only admin areas (payments, client portal lookups, etc.).
 * Normal admins cannot see or access these resources.
 */
abstract class FinanceResource extends Resource
{
    use ChecksAdminRole;

    protected static function requiresFinanceAccess(): bool
    {
        return true;
    }

    protected static string|UnitEnum|null $navigationGroup = 'Finance';
}
