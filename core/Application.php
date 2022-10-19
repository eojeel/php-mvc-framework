<?php
namespace app\core;

use app\core\Router;
use app\core\Request;
use app\core\Session;
use app\core\Database;
use app\core\Response;

class Application
{
    public static Application $app;
    public static string $ROOT_DIR;
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public ?dbModel $dbModel;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }

    public function login(dbModel $user)
    {
        print_r($user);
        print_r('anal');
        exit;
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}
