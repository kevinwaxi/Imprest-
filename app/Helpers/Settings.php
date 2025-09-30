<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('settings')) {
    function settings(string $key, $default = null)
    {
        static $settings;

        if (! $settings) {
            $settings = Cache::remember('settings', 3600, fn () =>
                Setting::all()->pluck('value', 'key')
            );
        }

        return $settings[$key] ?? $default;
    }
}

if (! function_exists('applyDefaults')) {
    function applyDefaults(array $data, string $settingsKey): array
    {
        $defaults = settings($settingsKey, []);
        return array_merge($defaults, $data);
    }
}
