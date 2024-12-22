<?php


use Illuminate\Support\Facades\File;

if (!function_exists('vite_package')) {
    function sVite(array $assets): void
    {
        $manifestPath = public_path('vendor/sone/core/.vite/manifest.json');
        if (!File::exists($manifestPath)) {
            throw new \Exception('Vite manifest for sOne Core not found.');
        }

        $manifest = json_decode(File::get($manifestPath), true);
        foreach ($assets as $asset) {
            if (!isset($manifest[$asset])) {
                throw new \Exception("Asset {$asset} not found in sOne Core Vite manifest.");
            }

            $assetPath = $manifest[$asset]['file'];
            $assetUrl = asset('vendor/sone/core/' . $assetPath);

            if (str_ends_with($asset, '.js')) {
                echo '<script type="module" src="' . $assetUrl . '"></script>';
            } elseif (str_ends_with($asset, '.css')) {
                echo '<link rel="stylesheet" href="' . $assetUrl . '">';
            }
        }
    }
}
