<?php

namespace Bilbo\Validation\Rules\Contract;

interface Rule extends \Stringable
{
    public function apply($field, $value, $data = []);
}
