<?php

namespace app\core;

use app\core\Model;

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
    }

    public static function prepare($sql)
    {
        return Application::$app->db->sqlLite->prepare($sql);
    }
}
