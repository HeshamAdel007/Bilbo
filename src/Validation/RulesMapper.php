<?php

namespace Bilbo\Validation;

use Bilbo\Validation\Rules\EmailRule;
use Bilbo\Validation\Rules\UniqueRule;
use Bilbo\Validation\Rules\BetweenRule;
use Bilbo\Validation\Rules\AlphaNumRule;
use Bilbo\Validation\Rules\RequiredRule;
use Bilbo\Validation\Rules\ConfirmedRule;

trait RulesMapper
{
    protected static array $map = [
        'required'  => RequiredRule::class,
        'alnum'     => AlphaNumRule::class,
        'between'   => BetweenRule::class,
        'email'     => EmailRule::class,
        'confirmed' => ConfirmedRule::class,
        'unique'    => UniqueRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new static::$map[$rule](...$options);
    }
}
