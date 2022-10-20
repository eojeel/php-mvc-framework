<?php

namespace app\core\exception;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'You Don\'t have permission to acccess this page ';
    protected $code = 403;
}
