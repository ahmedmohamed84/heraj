<?php

if (!function_exists('get_settings')) {
    function get_settings($key = null)
    {
        $settings = cache()->rememberForever('settings', function () {
            return \App\Models\Setting::pluck('value', 'key')->all();
        });

        if ($key) {
            return $settings[$key] ?? null;
        }

        return $settings;
    }
}