<?php

use Illuminate\Support\Facades\File;

if (!function_exists('sVite')) {
    function sVite(array $assets): void
    {
        $manifestPath = public_path('vendor/sone/core/.vite/manifest.json');
        if (!File::exists($manifestPath)) {
            throw new \Exception('Vite manifest for sOne Core not found.');
        }

        $manifest = json_decode(File::get($manifestPath), true);
        foreach ($assets as $asset) {
            $matchedKey = null;
            foreach ($manifest as $key => $value) {
                if (substr($key, -strlen($asset)) === $asset) {
                    $matchedKey = $key;
                    break;
                }
            }

            if (!$matchedKey) {
                throw new \Exception("Asset {$asset} not found in sOne Core Vite manifest.");
            }

            $assetEntry = $manifest[$matchedKey];
            $assetPath = $assetEntry['file'];
            $assetUrl = asset('vendor/sone/core/' . $assetPath);

            if (str_ends_with($asset, '.js')) {
                echo '<script type="module" src="' . $assetUrl . '"></script>';
            }

            if (isset($assetEntry['css'])) {
                foreach ($assetEntry['css'] as $css) {
                    $cssUrl = asset('vendor/sone/core/' . $css);
                    echo '<link rel="stylesheet" href="' . $cssUrl . '">';
                }
            } elseif (str_ends_with($asset, '.css')) {
                echo '<link rel="stylesheet" href="' . $assetUrl . '">';
            }
        }
    }
}
