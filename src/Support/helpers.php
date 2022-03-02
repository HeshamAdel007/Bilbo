<?php

use Bilbo\View\View;
use Bilbo\Application;
use Bilbo\Support\Hash;
use Bilbo\Validation\Validator;

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
        // If Value Is instanceof Closure Make Invoke Else Return Value
        return $value instanceof Closure ? $value() : $value;
    }
}

// Get Path
if (!function_exists('base_path')) {
    function base_path()
    {
        // Will Return Current Dir & Back One Dir
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

// Validations
if (!function_exists('validator')) {
    function validator()
    {
        return (new Validator());
    }
}

// Bcrypt
if (!function_exists('bcrypt')) {
    function bcrypt($data)
    {
        return Hash::make($data);
    }
}

// Database Path
if (!function_exists('database_path')) {
    function database_path()
    {
        return base_path() . 'database/';
    }
}

// Class Name
if (!function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}
