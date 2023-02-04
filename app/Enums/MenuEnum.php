<?php

namespace App\Enums;

use TiagoF2\Enums\Enum;

class MenuEnum extends Enum
{
    public const TYPE_SIDEBAR_HEADING = 0;
    public const TYPE_MENU_ITEM = 1;
    public const TYPE_COLLAPSE_DIVIDER = 2;
    public const TYPE_COLLAPSE_HEADER = 3;

    protected static array $enums = [
        self::TYPE_SIDEBAR_HEADING => 'sidebar-heading',
        self::TYPE_MENU_ITEM => 'menu-item',
        self::TYPE_COLLAPSE_DIVIDER => 'collapse-divider',
        self::TYPE_COLLAPSE_HEADER => 'collapse-header',
    ];
}
