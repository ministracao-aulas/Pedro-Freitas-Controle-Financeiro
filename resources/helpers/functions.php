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

if (!function_exists('piped')) {
    /**
     * function piped
     *
     * <code>piped(fn() => [], fn() => [], fn() => [], )->run()</code>
     * <code>piped(fn() => [])->pipe(fn() => [])->->pipe(fn() => [])->run()</code>
     * <code>$a = 0; piped(function() use (&$a) { $a = 12 + 5; }, function() use (&$a) { $a = $a - 7; }); echo $a;</code>
     *
     * @param callable ...$pipedItems
     *
     * @return object
     */
    function piped(callable ...$pipedItems): object
    {
        return new class($pipedItems) {
            public array $pipedItems;

            public function __construct(
                array $pipedItems = [],
            ) {
                $this->pipedItems = array_filter($pipedItems, fn ($item) => is_callable($item));
            }

            public function pipe(callable $item): static
            {
                $this->pipedItems[] = $item;

                return $this;
            }

            public function run(): void
            {
                foreach ($this->pipedItems as &$item) {
                    $copyOfCallable = $item;
                    unset($item);

                    if (!is_callable($copyOfCallable)) {
                        continue;
                    }

                    call_user_func($copyOfCallable);
                }
            }
        };
    }
}
