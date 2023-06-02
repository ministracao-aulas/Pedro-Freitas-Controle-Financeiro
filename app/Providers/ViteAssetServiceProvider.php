<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViteAssetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Blade::directive('vite_asset', fn ($asset) => "<?php echo vite_asset({$asset}); ?>");

        \Illuminate\Support\Facades\Blade::directive('viteAsset', fn ($asset) => "<?php echo vite_asset({$asset}); ?>");
    }
}
