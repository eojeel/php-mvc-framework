<?php

use app\core\Application;

require_once '../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/contact', 'contact');

$app->router->post('/contact', fn() => 'Sosig');

$app->run();
