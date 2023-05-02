<?php

namespace App\Modules\Menu\MenuRules;

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

    /**
     * function showWipItems
     *
     * @return bool
     */
    public static function showWipItems(): bool
    {
        return config('menu-tems.show_wip_items');
    }
}
