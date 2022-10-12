<?php

namespace app\core;

use SQLite3;

class Database
{
    public SQLite3 $sqlLite;

    public function __construct()
    {
        $this->sqlLite = new SQLite3(getenv('DBFILE'), SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/migrations');

        print_r($files);

        }

    public function createMigrationsTable()
    {
        $this->sqlLite->exec("CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    }

    public function getAppliedMigrations()
    {
        $stmt = $this->sqlLite->prepare("SELECT migration FROM migrations");
        $res = $stmt->execute();

        return $res->fetchArray(SQLITE3_ASSOC);
    }
}
