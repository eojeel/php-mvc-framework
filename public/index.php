<?php

use Dotenv\Dotenv;
use app\models\User;
use app\core\Application;
use app\controllers\AuthController;
use app\controllers\SiteController;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'file' => $_ENV['DBFILE']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [AuthController::class, 'profile']);

$app->run();
