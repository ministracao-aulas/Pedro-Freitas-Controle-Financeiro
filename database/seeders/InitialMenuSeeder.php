<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Enums\MenuEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class InitialMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::clearAllCachedMenu();

        $initialMenus = [
            [
                'identifier' => 'admin.login', // Identificador único
                'type_enum' => MenuEnum::TYPE_MENU_ITEM,
                'url' => \null,
                'icon' => 'fa fa-user',
                'class' => 'my-login-link',
                'label' => 'Login',
                'can' => [],
                'custom_menu_rule' => [
                    [Auth::class, 'guest'],
                ],
                'route' => 'login',
                'active_if_route_in' => [],
                'parent_id' => null,
                'relative_position' => 0,
                'active' => true,
                'show_only_to' => null,
            ],
        ];

        foreach ($initialMenus as $menuItem) {
            Menu::updateOrCreate([
                'identifier' => $menuItem['identifier'],
            ], $menuItem);
        }
    }
}
