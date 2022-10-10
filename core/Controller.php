<?php
namespace app\core;

class Controller
{
    public string $layout = 'main';

    public function render($view, $params = [])
    {
        return Application::$app->router->render($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
