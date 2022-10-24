<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        if(is_array($flashMessages))
        {
            foreach($flashMessages as $k => &$v)
            {
                $v['remove'] = true;
                $_SESSION[self::FLASH_KEY] = $v;
            }
        }
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        foreach($_SESSION[self::FLASH_KEY] ?? [] as $k => &$v)
        {
            if($v['remove'])
            {
                unset($v[$k]);
            }
        }
    }
}
