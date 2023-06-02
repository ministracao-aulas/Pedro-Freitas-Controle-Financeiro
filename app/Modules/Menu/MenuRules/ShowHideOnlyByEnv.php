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
        return \config('menu-tems.show_menu_wip_items', false) && static::showOnlyIn(['local', 'dev']);
    }
}
