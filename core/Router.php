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
        $method = $this->request->method();
        $callback = $this->routes[$method][$path];

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->render('errors/_404');
        }

        if (is_string($callback)) {
            return $this->render($callback);
        }

        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request);
    }

    /**
     *
     * @param mixed $callback
     * @return void
     */
    public function render($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$layout.php";
        return ob_get_clean();
    }

    /**
     * Undocumented function
     *
     * @param [type] $view
     * @param [type] $params
     * @return void
     */
    protected function renderView($view, $params)
    {
        foreach ($params as $k => $v) {
            $$k = $v;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
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
