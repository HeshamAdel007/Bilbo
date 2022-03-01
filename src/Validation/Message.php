<?php
namespace Bilbo\Validation;

class Message
{
    public static function generate($rule, $field)
    {
        return str_replace('%s', $field, $rule);
    }
}// End Class
