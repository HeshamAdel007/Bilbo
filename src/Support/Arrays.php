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

    // Check If Array Is Accessible OR No
    public static function accessible($value)
    {
        // If Accessible Will Return Array
        // OR Instance Of ArrayAccess
        return is_array($value) || $value instanceof ArrayAccess;
    } // End Accessible

    // Check If Value Exists
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    } // End Of Exists

    // Check If Array Has This Key | Value
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
            // Check Count
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

    // Gey All Array Except This Key
    public static function except($array, $keys)
    {
        static::forget($array, $keys);
        return $array;
    }

    // Transfer Array From Multi Diminution[[[[]]]]  To One []
    public static function flatten($array, $depth = INF)
    {
        $result = [];
        foreach ($array as $item) {
            // Check If Array
            // This Break
            if (!is_array($item)) {
                // Push $item To Result
                $result[] = $item;
            // Check Depth = 1
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge($result, static::flatten($item, $depth - 1));
            }
        }
        return $result;
    }

    public static function get($array, $key, $default = null)
    {
        //Check If Array IS Not Accessible
        if (!static::accessible($array)) {
            return value($default);
        }
        //Check If Array IS Null
        if (is_null($key)) {
            return $array;
        }
        //Check If Array IS Exist
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        if (mb_strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }
        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return ($default);
            }
        }
        return $array;
    }

    public static function set(&$array, $key, $value)
    {
        // Check If Is Null Key
        if (is_null($key)) {
            return $array = $value;
        }
        // Explodes Key
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            // Get First Element In Array
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }


    public static function unset($array, $key)
    {
        static::set($array, $key, null);
    }
} // End Of Class
