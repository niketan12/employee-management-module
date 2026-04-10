<?php

use Illuminate\Support\Str;

if (! function_exists('format_date')) {
    function format_date(?\DateTimeInterface $date, string $format = 'M d, Y'): string
    {
        return $date ? $date->format($format) : '';
    }
}

if (! function_exists('sanitize')) {
    function sanitize(string $value): string
    {
        return trim(strip_tags($value));
    }
}

if (! function_exists('config_value')) {
    function config_value(string $key, $default = null)
    {
        return config($key, $default);
    }
}

function pr($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

