<?php

namespace Bilbo\Validation\Rules;

use Bilbo\Validation\Rules\Contract\Rule;

// $valid = [
//     'name' => 'unique:user:name'
// ]
class UniqueRule implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table; // Table Name
        $this->column = $column; // Column name
    }

    public function apply($field, $value, $data =[])
    {
        return !(app()->db->raw("SELECT * FROM {$this->table} WHERE {$this->column} = ?", [$value]));
    }

    public function __toString()
    {
        return 'This %s is already taken';
    }
} // End Class
