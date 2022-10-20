<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    public int $id = 0;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = SELF::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';


    public function tableName() : string
    {
        return 'users';
    }

    public function primaryKey() : string
    {
        return 'id';
    }

    public function attributes() : array
    {
        return ['firstname','lastname','status','email','password'];
    }

    public function getDisplayName() : string
    {
        return $this->firstname .' : '.$this->lastname;
    }

    public function setUser(array $user)
    {
        foreach($user as $k => $v)
        {
            if(isset($this->$k))
            {
                $this->$k = $v;
            }
        }
    }

    public function register()
    {
        $this->status = SELF::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
                ]
            ],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 10] ],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

}
