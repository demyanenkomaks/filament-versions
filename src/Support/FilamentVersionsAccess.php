<?php

namespace Maksde\FilamentVersions\Support;

use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Throwable;

final class FilamentVersionsAccess
{
    /**
     * Доступ к виджету `FilamentVersionsWidget` на дашборде.
     */
    public static function canViewDashboardWidget(): bool
    {
        return self::check(config('filament-versions.widget.permission'));
    }

    /**
     * Доступ к маршруту и пункту меню страницы `VersionsPage`.
     */
    public static function canViewVersionsPage(): bool
    {
        return self::check(config('filament-versions.page.permission'));
    }

    /**
     * Доступ к виджету в шапке страницы версий (тот же замысел, что и у страницы).
     */
    public static function canViewVersionsPageWidget(): bool
    {
        return self::canViewVersionsPage();
    }

    /**
     * @param  string|array<int|string, mixed>|null  $permission  Имена прав Shield / `$user->can()`; для массива достаточно одного совпадения.
     */
    public static function check(string|array|null $permission): bool
    {
        if (in_array($permission, [null, [], ''], true)) {
            return true;
        }

        if (is_string($permission)) {
            $abilities = [$permission];
        } else {
            $abilities = [];
            foreach ($permission as $item) {
                if (is_string($item) && $item !== '') {
                    $abilities[] = $item;
                }
            }
        }

        if ($abilities === []) {
            return true;
        }

        $user = self::resolvePanelUser();
        if ($user === null) {
            return false;
        }

        if (! $user instanceof Authorizable) {
            return false;
        }

        foreach ($abilities as $ability) {
            if ($user->can($ability)) {
                return true;
            }
        }

        return false;
    }

    private static function resolvePanelUser(): ?Authenticatable
    {
        try {
            /** @var Authenticatable|null $user */
            $user = Filament::auth()->user();

            return $user;
        } catch (Throwable) {
            return null;
        }
    }
}
