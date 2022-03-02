<?php

namespace Bilbo\Database\Grammars;

use App\Models\Model;

class MySQLGrammar
{
    public static function buildInsertQuery($keys)
    {
        $values = '';
        for ($i = 0; $i < count($keys); $i++) {
            $values .= '?, ';
        }
        $query = 'INSERT INTO ' . Model::getTableName() . ' (`' . implode('`, `', $keys) . '`) VALUES(' . rtrim($values, ', ') . ')';
        return $query;
    } // End Of buildInsertQuery

    public static function buildSelectQuery($columns = '*', $filter = null)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }
        $query = "SELECT {$columns} FROM " . Model::getTableName();
        if ($filter) {
            $query .= " WHERE {$filter[0]} {$filter[1]} ?";
        }
        return $query;
    }// End Of buildSelectQuery

    public static function buildUpdateQuery($keys)
    {
        $query = 'UPDATE ' . Model::getTableName() . ' SET ';
        foreach ($keys as $key) {
            $query .= "{$key} = ?, ";
        }
        $query = rtrim($query, ', ') . ' WHERE ID = ?';
        return $query;
    }// End Of buildUpdateQuery

    public static function buildDeleteQuery()
    {
        return 'DELETE FROM ' . Model::getTableName() . ' WHERE ID = ?';
    }// End Of buildDeleteQuery
} // ENd Class
