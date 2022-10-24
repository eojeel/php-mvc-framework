<?php

namespace app\core;

class View
{
    public string $title = '';
    public string $layout = '';

    /**
     *
     * @param mixed $callback
     * @return void
     */
    public function render($view, $params = [])
    {
        $viewContent = $this->renderView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    protected function layoutContent()
    {
        $layout = $this->layout;
        if(Application::$app->controller)
        {
            $layout = Application::$app->controller->layout;
        }
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
}
