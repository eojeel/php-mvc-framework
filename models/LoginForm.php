<?php

namespace app\models;

use app\core\Model;
use app\models\User;
use app\core\Application;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules() : array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = new User();
        $loggedInUser = $user->findOne(['email' => $this->email]);
        if(!$loggedInUser)
        {
            $this->addError('email', 'User Does not exists with this email');
            return false;
        }
        if(!password_verify($this->password, $loggedInUser->password))
        {
            $this->addError('password', 'Incorrect password');
            return false;
        }

        return Application::$app->login($loggedInUser);
    }
}
