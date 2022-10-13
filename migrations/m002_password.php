<?php

use app\core\Database;

class m002_password
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->sqlLite->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->sqlLite->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
    }
}
