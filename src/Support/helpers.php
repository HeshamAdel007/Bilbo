<?php

use Bilbo\View\View;
use Bilbo\Application;

// Env File
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

// Get Path
if (!function_exists('base_path')) {
    function base_path()
    {
        // Will Return Carrent Dir & Back One Dir
        return dirname(__DIR__) . '/../';
    }
}

// Path View File
if (!function_exists('view_path')) {
    function view_path()
    {
        return  base_path() . 'views/';
    }
}

// View()
if (!function_exists('view')) {
    function view($view, $params = [])
    {
        echo View::make($view, $params);
    }
}

// App
if (!function_exists('app')) {
    function app()
    {
        static $instance = null;
        if (!$instance) {
            $instance = new Application();
        }
        return $instance;
    }
}

// Config File Path
if (!function_exists('config_path')) {
    function config_path()
    {
        return base_path() . 'config/';
    }
}

// Config
if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->config;
        }
        if (is_array($key)) {
            return app()->config->set($key);
        }
        return app()->config->get($key, $default);
    }
}
