<?php

namespace App\View\Components\SbAminMenu;

use App\Modules\Menu\MenuItem as MenuMenuItem;
use Illuminate\View\Component;

class MenuItem extends Component
{
    protected MenuMenuItem $menuItem;
    protected ?bool $display = true;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        MenuMenuItem $menuItem
    ) {
        $this->menuItem = $menuItem;
        $this->display = $menuItem->toDisplay();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(
            'components.sb-amin-menu.menu-item',
            [
                'menuItem' => $this->menuItem,
                'display' => $this->display,
            ]
        );
    }
}
