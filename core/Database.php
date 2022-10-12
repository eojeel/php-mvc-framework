<?php

namespace app\core;

use SQLite3;
use app\core\Application;

class Database
{
    public SQLite3 $sqlLite;

    public function __construct()
    {
        $this->sqlLite = new SQLite3($_ENV['DBFILE'], SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    }

    public function applyMigrations()
    {
        $completedMigrations = [];
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $migrationsRun = array_diff($files, ['.','..'], $appliedMigrations);
        foreach($migrationsRun as $migration)
        {
            include_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying Migration $migration".PHP_EOL;
            $instance->up();
            $completedMigrations[] = $migration;
        }

        if(!empty($completedMigrations))
        {
            $this->savedMigrations($completedMigrations);
        }
    }

    public function createMigrationsTable()
    {
        $this->sqlLite->query("CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    }

    public function getAppliedMigrations()
    {
        $results = [];

        $stmt = $this->sqlLite->query("SELECT migration FROM migrations");
        while($res = $stmt->fetchArray(SQLITE3_ASSOC)){
            $results[] = $res;
        }
        return $results;
    }

    public function savedMigrations(array $migrations)
    {
        $migrations = implode(',', array_map(fn($m) => "('$m')", $migrations));

        $this->sqlLite->exec("INSERT INTO migrations (migration) VALUES ".$migrations."");
    }
}
