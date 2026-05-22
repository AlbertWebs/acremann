<?php

namespace App\Filament\Concerns;

use App\Models\User;

trait ChecksAdminRole
{
    protected static function requiresSuperAdminAccess(): bool
    {
        return false;
    }

    protected static function requiresFinanceAccess(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return false;
        }

        if (static::requiresSuperAdminAccess() && ! $user->isSuperAdmin()) {
            return false;
        }

        if (static::requiresFinanceAccess() && ! $user->canAccessFinance()) {
            return false;
        }

        return parent::canAccess();
    }
}
