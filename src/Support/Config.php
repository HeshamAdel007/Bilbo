<?php

namespace Bilbo\Support;

use ArrayAccess;

class Config implements ArrayAccess
{
    protected array $items = [];

    public function __construct($items)
    {
        foreach ($items as $key => $item) {
            $this->items[$key] = $item;
        }
    } // End Of construct

    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }
        return Arrays::get($this->items, $key, $default);
    } // End Of get


    public function getMany($keys)
    {
        $config = [];
        foreach ($keys as $key => $default) {
            // Check Key If Is Numeric
            if (is_numeric($key)) {
                // swap Element
                [$key, $default] = [$default, null];
            }
            $config[$key] = Arrays::get($this->items, $key, $default);
        }
        return $config;
    } // End Of getMany

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $key => $value) {
            Arrays::set($this->items, $key, $value);
        }
    } // End Of set

    public function push($key, $value)
    {
        $array = $this->get($key);
        $array[] = $value;
        $this->set($key, ...$array);
    }// End Of push

    public function all()
    {
        return $this->items;
    }// End Of all

    public function exists($key)
    {
        return Arrays::exists($this->items, $key);
    } // ENd Of exists

    
    //==================== ArrayAccess Methods =======================//
    public function offsetExists($offset): bool
    {
        return $this->exists($offset);
    }
    public function offsetGet($offset): mixed
    {
        $this->get($offset);
    }
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }
    public function offsetUnset($offset): void
    {
        $this->set($offset, null);
    }
} // End Of Class
