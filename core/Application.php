<?php
namespace app\core;

use app\core\View;
use app\core\Router;
use app\core\Request;
use app\core\Session;
use app\core\Response;
use app\core\db\dbModel;
use app\core\db\Database;

class Application
{
    public static Application $app;
    public static string $ROOT_DIR;
    public string $userClass;

    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public View $view;

    public ?Controller $controller = null;
    public ?dbModel $dbModel;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->userClass = $config['userClass'];
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);


        $primaryValue = $this->session->get('user');
        if($primaryValue)
        {
            $userclass = new $this->userClass();
            $primaryKey = $userclass->primaryKey();
            $this->user = $userclass->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function login(dbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
           echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->render('_error', [
                'exception' => $e
                ]);
        }

    }

}
