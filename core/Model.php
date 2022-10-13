<?php
namespace app\core;

abstract class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';

    abstract public function rules(): array;
    public array $errors = [];


    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
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

    /**
     * Undocumented function
     *
     * @return void
     */
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

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addError($attribute, SELF::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                {
                    $this->addError($attribute, SELF::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                {
                    print_r($rule);
                    exit;
                    $this->addError($attribute, SELF::RULE_MAX, $rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addError($attribute, SELF::RULE_MATCH, $rule);
                }

                if($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr =$rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $stmt = Application::$app->db->sqlLite->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $stmt->bindValue(":$attribute", $value);
                    $results = $stmt->execute();
                    $result = $results->fetchArray();
                    if($result)
                    {
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Undocumented function
     *
     * @param string $attribute
     * @param string $rule
     * @param array $params
     * @return void
     */
    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessage()[$rule] ?? '';
        foreach($params as $k => $v)
        {
            $message = str_replace("{{$k}}", $v, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * Undocumented function
     *
     * @param [type] $attribute
     * @return boolean
     */
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Undocumented function
     *
     * @param [type] $attribute
     * @return void
     */
    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists'
        ];
    }

}
