<?php

namespace App\Modules\Menu\MenuRules;

use App\Models\Menu;

class ShowHideOnlyByEnv
{
    /**
     * function showOnlyIn
     *
     * @param array $envs
     * @return bool
     */
    public static function showOnlyIn(array $envs): bool
    {
        return app()->environment($envs);
    }

    /**
     * function showOnlyInDev
     *
     * @return bool
     */
    public static function showOnlyInDev(): bool
    {
        return static::showOnlyIn(['local', 'dev']);
    }
}
