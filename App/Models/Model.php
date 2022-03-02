<?php

namespace App\Models;

use Bilbo\Support\Str;

abstract class Model
{
    protected static $instance;

    public static function create(array $attributes)
    {
        self::$instance = static::class;
        return app()->db->create($attributes);
    } // End OF create

    public static function all()
    {
        self::$instance = static::class;
        return app()->db->read();
    } // End OF all

    public static function delete($id)
    {
        self::$instance = static::class;
        return app()->db->delete($id);
    } // End OF delete

    public static function update($id, array $attributes)
    {
        self::$instance = static::class;
        return app()->db->update($id, $attributes);
    } // End OF update

    public static function where($filter, $columns = '*')
    {
        self::$instance = static::class;
        return app()->db->read($columns, $filter);
    } // End OF where

    public static function getModel()
    {
        return self::$instance;
    } // End OF getmodel

    // Get Table Name From Any Instance From Model
    public static function getTableName()
    {
        return Str::lower(Str::plural(class_basename(self::$instance)));
    } // End OF gettablename
}// End Class
