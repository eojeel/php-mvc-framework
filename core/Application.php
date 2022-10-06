<?php
namespace app\core;

use app\core\Router;
use app\core\Request;


class Application
{
    public Router $router;
    public Request $request;

    public function __construct()
    {
        $request = $this->request = new Request();
        $this->router = new Router($request);


    }

    public function run()
    {
        $this->router->resolve();
    }

}
