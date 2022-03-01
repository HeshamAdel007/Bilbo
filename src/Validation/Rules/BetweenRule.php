<?php

namespace Bilbo\Validation\Rules;

use Bilbo\Validation\Rules\Contract\Rule;

class BetweenRule implements Rule
{
    protected int $min;
    protected int $max;
    
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function apply($field, $value, $data = [])
    {
        if (strlen($value) < $this->min) {
            return false;
        }
        if (strlen($value) > $this->max) {
            return false;
        }
        return true;
    }

    public function __toString()
    {
        return "%s must be between {$this->min} and {$this->max} characters";
    }
} // End Class
