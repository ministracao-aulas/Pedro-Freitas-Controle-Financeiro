<?php

namespace App\Modules\Menu;

class MenuItem
{
    protected ?bool $display = true;

    public function __construct(
        array $menuItemData,
        ?bool $display = true
    ) {
        $this->mapData($menuItemData);

        $this->display = $display;
    }

    /**
     * function make
     *
     * @param array $menuItemData,
     * @param ?bool $display
     *
     * @return MenuItem
     */
    public static function make(
        array $menuItemData,
        ?bool $display = true
    ): MenuItem {
        return new static(
            $menuItemData,
            $display
        );
    }

    /**
     * function mapData
     *
     * @param array $menuItemData
     *
     * @return void
     */
    protected function mapData(array $menuItemData): void
    {
        $this->{'isActive'} = false;

        foreach ($menuItemData as $key => $value) {
            if (!\is_string($key) || \is_numeric($key)) {
                continue;
            }

            $this->{$key} = $value;
        }

        $this->{'menuItemUid'} = 'collapsePages_' . \Str::random(10) . rand(5, 5);

        $activeIfRouteIn = $menuItemData['active_if_route_in'] ?? \null;
        $route = $menuItemData['route'] ?? \null;
        $url = $menuItemData['url'] ?? \null;

        if ($activeIfRouteIn && \is_array($activeIfRouteIn)) {
            $this->{'isActive'} = \in_array(
                \Route::currentRouteName(),
                \array_filter(\array_values($activeIfRouteIn), fn ($item) => is_string($item) && trim($item)),
                true
            );
        }

        if (!$route && !$url) {
            return;
        }

        if ($route && \is_string($route) && \trim($route)) {
            $routeParams = $menuItemData['route_params'] ?? \null;

            $this->{'url'} = ($routeParams && \is_array($routeParams))
                ? route(\trim($route), $routeParams)
                : route(\trim($route));
        }

        if (!$this->{'url'}) {
            $this->{'url'} = '#!';
        }

        if (
            !$this->{'sub_items'} ||
            !is_countable($this->{'sub_items'}) ||
            !count($this->{'sub_items'})
        ) {
            $this->{'sub_items'} = [];
        }
    }

    /**
     * function toDisplay
     *
     * @return bool
     */
    public function toDisplay(): bool
    {
        return (bool) $this->display;
    }

    /**
     * function __get
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->{$key} ?? null;
    }
}
