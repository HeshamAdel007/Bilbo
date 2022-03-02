<?php

namespace Bilbo\Database\Managers;

use App\Models\Model;
use Bilbo\Database\Grammars\MySQLGrammar;
use Bilbo\Database\Managers\Contracts\DatabaseManager;

class MySQLManager implements DatabaseManager
{
    protected static $instance;

    public function connect(): \PDO
    {
        if (!self::$instance) {
            self::$instance = new \PDO(env('DB_DRIVER') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
        }
        return self::$instance;
    } // End Of connect

    public function query(string $query, $values = [])
    {
        $stmt = self::$instance->prepare($query);
        for ($i = 1; $i <= count($values); $i++) {
            $stmt->bindValue($i, $values[$i - 1]);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } // End Of query

    public function read($columns = '*', $filter = null)
    {
        $query = MySQLGrammar::buildSelectQuery($columns, $filter);
        $stmt = Self::$instance->prepare($query);
        if ($filter) {
            $stmt->bindValue(1, $filter[2]);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    } // End Of read

    public function create($data)
    {
        $query = MySQLGrammar::buildInsertQuery(array_keys($data));
        $stmt = self::$instance->prepare($query);
        for ($i = 1; $i <= count($values = array_values($data)); $i++) {
            $stmt->bindValue($i, $values[$i - 1]);
        }
        return $stmt->execute();
    } // end Of Create

    public function update($id, $attributes)
    {
        $query = MySQLGrammar::buildUpdateQuery(array_keys($attributes));
        $stmt = self::$instance->prepare($query);
        for ($i = 1; $i <= count($values = array_values($attributes)); $i++) {
            $stmt->bindValue($i, $values[$i - 1]);
            if ($i == count($values)) {
                $stmt->bindValue($i + 1, $id);
            }
        }
        return $stmt->execute();
    } // End Of update

    public function delete($id)
    {
        $query = MySQLGrammar::buildDeleteQuery();
        $stmt = self::$instance->prepare($query);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    } // End Of delete
} // End Of Class
