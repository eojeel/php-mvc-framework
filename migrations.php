<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Dotenv\Dotenv;
use app\models\User;
use app\core\Application;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'file' => $_ENV['DBFILE']
    ]
];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();
