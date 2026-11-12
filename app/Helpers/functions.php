<?php

if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('getSettingValue')) {
    function getSettingValue(array $settings, string $key): string {
        return (string) ($settings[$key]['setting_value'] ?? '');
    }
}

if (!function_exists('getSetting')) {
    function getSetting(array $settings, string $key, string $default = ''): string {
        $value = $settings[$key]['setting_value'] ?? $default;
        return (string) $value;
    }
}