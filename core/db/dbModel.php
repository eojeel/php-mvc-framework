<?php

namespace app\core\db;

use app\core\Model;
use app\models\User;
use app\core\Application;

abstract class dbModel extends Model
{
    abstract public function tableName() : string;

    abstract public function attributes() : array;

    abstract public function primaryKey() : string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statment = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).")
        VALUES(".implode(',',$params).")");
        foreach($attributes as $attribute)
        {
            $statment->bindValue(":$attribute", $this->{$attribute});
        }
        $statment->execute();
        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->sqlLite->prepare($sql);
    }

    public function findOne($where) // ['email' => 'email@email.com']
    {
        $tableName = $this->tableName();
        $sql = implode("AND ",
        array_map(fn($attr) => "$attr = :$attr",
        array_keys($where)));

        $statment = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach($where as $k => $v)
        {
            $statment->bindParam(":$k", $v);
        }

        $rs = $statment->execute();
        $result = $rs->fetchArray(SQLITE3_ASSOC);
        if(empty($result))
        {
            return false;
        }

        $user = new User();
        $user->setUser($result);
        return $user;
    }
}
