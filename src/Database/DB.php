<?php

namespace Bilbo\Database;

use Bilbo\Database\Concerns\ConnectsTo;
use Bilbo\Database\Managers\Contracts\DatabaseManager;

class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    } // End Of __construct

    public function init()
    {
        // ConnectsTo::connect($this->manager);
        (new class {
            use ConnectsTo;
        })::connect($this->manager);
    }// End Of init

    protected function raw(string $query, $value = [])
    {
        return $this->manager->query($query, $value);
    }// End Of row

    protected function create(array $data)
    {
        return $this->manager->create($data);
    }// End Of create

    protected function delete($id)
    {
        return $this->manager->delete($id);
    }// End Of delete

    protected function update($id, array $attributes)
    {
        return $this->manager->update($id, $attributes);
    }// End Of update

    protected function read($columns = '*', $filter = null)
    {
        return $this->manager->read($columns, $filter);
    }// End Of read

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
    }// End Of  __call
} // End Class
