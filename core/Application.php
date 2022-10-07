<?php
namespace app\core;

use app\core\Router;
use app\core\Request;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $request = $this->request = new Request();
        $this->router = new Router($request);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}
