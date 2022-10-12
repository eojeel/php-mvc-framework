<?php

use app\core\Application;
use app\controllers\SiteController;

test('has home', function() {
    $app = new Application(dirname(__DIR__));
    $app->router->get('/', [SiteController::class, 'home']);
    $this->assertStringContainsString('Welcome to Minimal Blog', $app->run());
});
