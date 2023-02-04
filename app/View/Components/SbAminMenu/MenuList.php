<?php

namespace App\View\Components\SbAminMenu;

use App\Models\User;
use App\Modules\Menu\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MenuList extends Component
{
    protected array $menuItems;
    protected ?User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->menuItems = [];

        foreach ($this->getAllAvailableMenuItems() as $item) {
            $menuItem = static::createMenuItem($item);

            if (!$menuItem) {
                continue;
            }

            $this->menuItems[] = $menuItem;
        }
    }

    /**
     * function getAllAvailableMenuItems
     *
     * @return array
     */
    public function getAllAvailableMenuItems(): array
    {
        try {
            $currentMenuItems = $this->user ? $this->user->availableMenuItems()?->toArray() : [];
        } catch (\Throwable $th) {
            \Log::error($th);
        }

        return \array_merge(config('menu-tems.items', []), $currentMenuItems ?? []);
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

        $customMenuRule = $menuItem['custom_menu_rule'] ?? [];

        if ($customMenuRule) {
            foreach ($customMenuRule as $menuRule) {
                if (\is_callable($menuRule) && !\call_user_func($menuRule)) {
                    return \null;
                }

                if (\is_bool($menuRule) && !$menuRule) {
                    return \null;
                }
            }
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
