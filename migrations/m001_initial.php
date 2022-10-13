<?php

use app\core\Database;

class m001_initial
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $sql = "CREATE TABLE users (
            id INTEGER PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->sqlLite->exec($sql);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $sql = "DROP TABLE users;";
        $db->sqlLite->exec($sql);
    }
}
