<?php
namespace App\core;

abstract class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';


    public function loadData($data)
    {
        foreach($data as $k => $v)
        {
            if(property_exists($this, $k))
            {
                $this->{$k} = $v;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validate()
    {
        foreach($this->rules() as $attribute => $rules)
        {
            $value = $this->{$attribute};
            foreach($rules as $rule)
            {
                $ruleName = $rule;
                if(!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addError($attribute, SELF::RULE_REQUIRED);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule)
    {
        $message = $this->errorMessage()[$rule] ?? '';
        $this->errors[$attribute][] = $message;
    }

    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
        ];
    }
}
