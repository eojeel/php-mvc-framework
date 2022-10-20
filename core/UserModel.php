<?php
namespace app\core;

abstract class UserModel extends dbModel
{
    abstract public function getDisplayName() : string;

}
