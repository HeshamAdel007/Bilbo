<?php
namespace Bilbo\Support;

use ArrayAccess;

class Arrays
{
    public static function only($array, $keys)
    {
        // First Arrays With key
        // Seconde Arrays Will bee Keys Will Matches
        // (['username' => 'hesham', 'email'=> 'heshamadel528@gmail.com'], ['email'])
        return array_intersect_key($array, array_flip((array) $keys));
    } // End Only

    // Chack If Array Is Accessible OR No
    public static function accessible($value)
    {
        // If Accessible Will Return Array
        // OR Instance Of ArrayAccess
        return is_array($value) || $value instanceof ArrayAccess;
    } // End Accessible

    // Chack If Value Exists
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    } // End Of Exists

    // Chack If Array Has This Key | Value
    public static function has($array, $keys)
    {
        // If Key Null
        if (is_null($keys)) {
            return false;
        }

        // If Keys A String
        $keys = (array) $keys;

        // If NotArray
        if (!$array) {
            return false;
        }

        // If Array Is Empty
        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $array;
            // If Array Has Key Continue
            if (static::exists($array, $key)) {
                continue;
            }
            foreach (explode('.', $key) as $segment) {
                if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }
        return true;
    } // End Of has

    // Get First Item
    public static function first($array, callable $callback = null, $default = null)
    {
        // If Callback Is Null
        if (is_null($callback)) {
            // If Empty
            if (empty($array)) {
                return value($default);
            }
            // else Is NotNull
            foreach ($array as $item) {
                return $item;
            }
        }
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return call_user_func($callback, $value, $key);
            }
        }
        return value($default);
    } // End Of First

    // Get Last Item
    public static function last($array, callable $callback = null, $default = null)
    {
        // If Callback Is Null
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }
        // If Callback Not Null
        return static::first(array_reverse($array, true), $callback, $default);
    } // End Last


    public static function forget(&$array, $keys)
    {
        $original = &$array;
        $keys = (array) $keys;
        // Check Key Count ==0
        if (count($keys) === 0) {
            return;
        }
        foreach ($keys as $key) {
            // If Exact key Exists In Top-level  remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);
            // Clean Up Before Each Pass
            $array = &$original;
            // Chack Count
            while (count($parts) > 1) {
                $part = array_shift($parts);
                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }
            unset($array[array_shift($parts)]);
        }
    } // End Of Forget
} // End Of Class
