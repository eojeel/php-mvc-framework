<?php
namespace app\core;

use app\core\Response;
use app\core\Router;
use app\core\Request;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}
