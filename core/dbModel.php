<?php

namespace app\core;

use app\core\Model;
use pp\models\User;

abstract class dbModel extends Model
{
    abstract public function tableName() : string;

    abstract public function attributes() : array;

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
        $tableName = static::tableName();
        $sql = implode("AND ",
        array_map(fn($attr) => "$attr = :$attr",
        array_keys($where)));

        $statment = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach($where as $k => $v)
        {
            $statment->bindParam(":$", $v);
        }
        $rs = $statment->execute();
        $results = $rs->fetchArray();

        echo $results;
        exit;

        // $user = new User();
        // $user->password = $results['password'];

        // return $user;
    }
}
