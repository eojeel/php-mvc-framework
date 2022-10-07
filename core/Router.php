<?php

namespace app\core;

use app\core\Request;

class Router
{
    public Request $request;
    protected array $routes = [];

    /**
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
     * @return mixed
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path];
        if (!$callback) {
            return "Not Found";
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
