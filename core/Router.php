<?php

namespace app\core;

use app\core\exception\NotFoundException;
use app\core\Request;
use app\core\Response;

class Router
{
    public string $layout = 'main';

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     *
     * @param mixed $path
     * @param mixed $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     *
     * @param mixed $path
     * @param mixed $callback
     * @return void
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     *
     * @return mixed
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return $this->view->render($callback);
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware)
            {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Undocumented function
     *
     * @param Controller $controller
     * @return void
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }
}
