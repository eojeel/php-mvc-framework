<?php
namespace app\core;

use app\core\db\dbModel;

abstract class UserModel extends dbModel
{
    abstract public function getDisplayName() : string;

}
