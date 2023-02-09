<?php
namespace app\controllers;

use app\models\User;
use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\core\Application;
use app\models\LoginForm;
use app\core\middlewares\AuthMiddleware;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
    $LoginForm = new LoginForm();
        if($request->isPost())
        {
            $LoginForm->loadData($request->getBody());
            if($LoginForm->validate() && $LoginForm->login())
            {
                Application::$app->session->setFlash('flash_messages', 'Thanks for Logging In!');
                $response->redirect('/');
                return;
            }
        }

        $this->setLayout('auth');

        return $this->render('login', [
            'model' => $LoginForm]
        );
    }

    public function register(Request $request)
    {
        $User = new User();

        if($request->isPost())
        {
            $User->loadData($request->getBody());
            if($User->validate() && $User->register())
            {
                $loggedInUser = $User->findOne(['email' => $User->email]);

                Application::$app->session->setFlash('flash_messages', 'Thanks for Registering');
                Application::$app->login($loggedInUser);
                Application::$app->response->redirect('/');
            }

            return $this->render('register', [
                'model' => $User]
            );
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $User]
        );
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');
    }
}
