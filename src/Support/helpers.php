<?php

use Bilbo\View\View;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        // If Key Exist Return $key If NotExist Return $default
        return $_ENV[$key] ?? value($default);
    }
}


if (!function_exists('value')) {
    function value($value)
    {
        // If Value Is instanceof Closure Make Invoic Else Return Value
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('base_path')) {
    function base_path()
    {
        // Will Return Carrent Dir & Back One Dir
        return dirname(__DIR__) . '/../';
    }
}

if (!function_exists('view_path')) {
    function view_path()
    {
        return  base_path() . 'views/';
    }
}


if (!function_exists('view')) {
    function view($view, $params = [])
    {
        echo View::make($view, $params);
    }
}
