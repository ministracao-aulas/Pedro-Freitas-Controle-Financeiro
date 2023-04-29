    <!-- Nav Items -->

    @foreach ($menuItems as $menuItem)
        @if(gettype($menuItem) != 'object' || get_class($menuItem) != 'App\Modules\Menu\MenuItem')
            @continue
        @endif

        @if($menuItem->type == 'sidebar-divider')
            <!-- Divider -->
            <hr
                class="{{ implode(' ', [
                    'sidebar-divider', ($menuItem->class ?? ''),
                ]) }}"
            >
            @continue
        @endif

        @if($menuItem->type == 'sidebar-heading' && $menuItem->label)
            <!-- Heading -->
            <div
                class="{{ implode(' ', [
                    'sidebar-heading', ($menuItem->class ?? ''),
                ]) }}"
            >
                {{ $menuItem->label }}
            </div>
            @continue
        @endif

        @if($menuItem->type == 'menu-item' && $menuItem->label && $menuItem->url)
            <!-- Nav Item - {{ $menuItem->label }} Menu -->
            @if ($menuItem->sub_items)
                <li
                    class="{{ implode(' ', [
                        'nav-item', ($menuItem->class ?? ''),
                        $menuItem->ifActiveClasses(),
                        (($menuItem->isActive ?? null) ? 'active' : '')
                    ]) }}"
                    x-data="{
                        toggleMenuItem(item) {
                            let menuItemsElement = document.querySelector(`#${item}`);

                            if (!menuItemsElement) {
                                return;
                            }

                            menuItemsElement.classList.toggle('show')
                        }
                    }"
                >
                    <a
                        class="{{ implode(' ', [
                            'nav-link',
                            ($menuItem->isActive ?? null) ? 'active' : '',
                            ($menuItem->class ?? ''),
                        ]) }}"

                        @click="toggleMenuItem('{{ $menuItem->menuItemUid }}')"

                        aria-expanded="{{ ($menuItem->isActive ?? null) ? 'true' : 'false' }}"

                        href="{{ $menuItem->url ?? '#!' }}"
                        data-toggle_="collapse"
                        data-target="#{{ $menuItem->menuItemUid }}"
                        aria-controls="{{ $menuItem->menuItemUid }}"
                    >
                        @if ($menuItem->icon)
                            <i class="{{ $menuItem->icon }}"></i>
                        @endif
                        <span>{{ $menuItem->label }}</span>
                    </a>

                    <div
                        id="{{ $menuItem->menuItemUid }}"
                        class="{{ implode(' ', [
                            'collapse',
                            (($menuItem->isActive ?? null) ? 'to_show_on_load' : '')
                        ]) }}"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar"
                        @mousedown.outside="removeShowOnToggled"
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach ($menuItem->sub_items as $subItem)
                                @if (!($subItem->type ?? null))
                                    @continue
                                @endif

                                @if (
                                    \in_array(($subItem->type ?? ''), [
                                        'collapse-divider',
                                        'collapse-header',
                                    ], true)
                                )
                                    @if ($subItem->type == 'collapse-header')
                                        @if ($subItem->label)
                                            <h6 class="collapse-header">
                                                @if ($subItem->url ?? null)
                                                    <a
                                                        class="collapse-item {{ $subItem->ifActiveClasses() }}"
                                                        href="{{ $subItem->url }}"
                                                        data-prevent-default-onclick="{{ $subItem->isCurrentUrl() ? 'true' : 'false' }}"
                                                    >
                                                        {{ $subItem->label }}
                                                    </a>
                                                @else
                                                {{ $subItem->label }}:
                                                @endif
                                            </h6>
                                        @endif
                                    @else
                                        <hr class="collapse-divider">
                                    @endif

                                    @continue;
                                @endif

                                @if ($subItem->url ?? null)
                                    <a
                                        class="{{ implode(' ', [
                                            'collapse-item', ($subItem->class ?? ''),
                                            $subItem->ifActiveClasses()
                                        ]) }}"
                                        href="{{ $subItem->url }}"
                                        data-prevent-default-onclick="{{ $subItem->isCurrentUrl() ? 'true' : 'false' }}"
                                    >
                                    @if ($subItem->icon)
                                        <i class="{{ $subItem->icon }}"></i>
                                    @endif
                                @endif

                                    {{ $subItem->label }}

                                @if ($subItem->url ?? null)
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @else
                <li
                    class="{{ implode(' ', [
                        'nav-item', ($menuItem->class ?? ''),
                        $menuItem->ifActiveClasses(),
                        (($menuItem->isActive ?? null) ? 'active' : '')
                    ]) }}"
                >
                    <a
                        class="{{ implode(' ', [
                            'nav-link', ($menuItem->class ?? ''),
                            $menuItem->ifActiveClasses(),
                        ]) }}"
                        href="{{ $menuItem->url ?? '#!' }}"
                    >
                        @if ($menuItem->icon)
                            <i class="{{ $menuItem->icon }}"></i>
                        @endif
                        <span>{{ $menuItem->label }}</span>
                    </a>
                </li>
            @endif
            @continue
        @endif
    @endforeach
