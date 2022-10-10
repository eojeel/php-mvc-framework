<?php

namespace app\core;

use app\core\Request;
use app\core\Response;

class Router
{
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
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path];
        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->render('errors/_404');
        }

        if(is_string($callback))
        {
            return $this->render($callback);
        }

        return call_user_func($callback);
    }

    /**
     *
     * @param mixed $callback
     * @return void
     */
    public function render($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/main.php";
        return ob_get_clean();
    }

    protected function renderView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

}
