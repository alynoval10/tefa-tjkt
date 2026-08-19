<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasRolePermission
{
    protected static function hasRoles(array $roles): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return in_array(
            auth()->user()->role,
            $roles,
            true
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::hasRoles(static::$viewRoles ?? []);
    }

    public static function canViewAny(): bool
    {
        return static::hasRoles(static::$viewRoles ?? []);
    }

    public static function canCreate(): bool
    {
        return static::hasRoles(static::$createRoles ?? []);
    }

    public static function canEdit(Model $record): bool
    {
        return static::hasRoles(static::$editRoles ?? []);
    }

    public static function canDelete(Model $record): bool
    {
        return static::hasRoles(static::$deleteRoles ?? []);
    }
}