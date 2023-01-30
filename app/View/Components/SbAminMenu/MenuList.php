<?php

namespace App\View\Components\SbAminMenu;

use App\Modules\Menu\MenuItem;
use Illuminate\View\Component;

class MenuList extends Component
{
    protected array $menuItems;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menuItems = [];

        foreach (config('menu-tems.items', []) as $item) {
            $menuItem = static::createMenuItem($item);

            if (!$menuItem) {
                continue;
            }

            $this->menuItems[] = $menuItem;
        }
    }

    /**
     * function createMenuItem
     *
     * @param ?array $menuItem
     * @return ?MenuItem
     */
    public static function createMenuItem($menuItem): ?MenuItem
    {
        $acceptedTypes = [
            'menu-item',
            'sidebar-divider',
            'collapse-divider',
            'sidebar-heading',
            'collapse-header',
        ];

        if (
            !is_array($menuItem) ||
            !count($menuItem) ||
            !\in_array(($menuItem['type'] ?? ''), $acceptedTypes, true)
        ) {
            return null;
        }

        $subItems = [];

        if (
            is_array(($menuItem['sub_items'] ?? null)) &&
            count(($menuItem['sub_items'] ?? []))
        ) {
            foreach ($menuItem['sub_items'] as $subItem) {
                $generatedSubItem = static::createMenuItem($subItem);

                if ($generatedSubItem) {
                    $subItems[] = $generatedSubItem;
                }
            }
        }

        $menuItem['sub_items'] = $subItems;

        return MenuItem::make($menuItem, true);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(
            'components.sb-amin-menu.menu-list',
            [
                'menuItems' => $this->menuItems,
            ]
        );
    }
}
