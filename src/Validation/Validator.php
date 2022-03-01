<?php
namespace Bilbo\Validation;

use Bilbo\Validation\Rules\Contract\Rule;

class Validator
{
    protected array $data = [];
    protected array $rules = [];
    protected array $aliases = [];
    protected ErrorBag $errorBag;

    public function make($data)
    {
        $this->data = $data;
        $this->errorBag = new ErrorBag();
        $this->validate();
    } // End make

    protected function validate()
    {
        foreach ($this->rules as $field => $rules) {
            foreach (RulesResolver::make($rules) as $rule) {
                $this->applyRule($field, $rule);
            }
        }
    }// End Of validate

    public function setRules($rules)
    {
        $this->rules = $rules;
    } // End Of setRules

    protected function applyRule($field, Rule $rule)
    {
        if (!$rule->apply($field, $this->getFieldValue($field), $this->data)) {
            $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
        }
    }// End Of applyRule

    public function passes()
    {
        return empty($this->errors());
    } // End Of passes

    public function errors($key = null)
    {
        return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
    }// End Of Errors

    public function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }// End Of alias

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    } // End Of setAliases

    protected function getFieldValue($field)
    {
        return $this->data[$field] ?? null;
    }// End Of getFieldValue
}// End Class
