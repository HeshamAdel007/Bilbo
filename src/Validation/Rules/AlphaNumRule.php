<?php

namespace Bilbo\Validation\Rules;

use Bilbo\Validation\Rules\Contract\Rule;

class AlphaNumRule implements Rule
{
    public function apply($field, $value, $data = [])
    {
        return preg_match('/^[a-zA-Z0-9_ -]+$/', $value);
    }

    public function __toString()
    {
        return '%s must be alpha numeric only';
    }
} // End Class
