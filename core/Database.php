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
}
