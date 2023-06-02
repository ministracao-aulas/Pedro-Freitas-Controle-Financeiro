<?php

if (!function_exists('vite_asset')) {
    /**
     * Get the URL for an asset.
     *
     * @param  string  $asset
     * @param  string|null  $buildDirectory
     * @return null|string
     */
    function vite_asset(string|array $asset, $buildDirectory = null): null|string
    {
        if (!$asset || !trim($asset)) {
            return null;
        }

        $asset = trim($asset);

        /**
         * @var \Illuminate\Foundation\Vite $vite
         */
        $vite = app(\Illuminate\Foundation\Vite::class);

        return $vite->asset($asset, $buildDirectory);
    }
}
