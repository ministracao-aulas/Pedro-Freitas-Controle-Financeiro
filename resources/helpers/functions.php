<?php

use App\Modules\Menu\MenuRules\ShowHideOnlyByEnv;

if (!function_exists('showWipItems')) {
    /**
     * function showWipItems
     *
     * @return bool
     */
    function showWipItems(): bool
    {
        return ShowHideOnlyByEnv::showWipItems();
    }
}
