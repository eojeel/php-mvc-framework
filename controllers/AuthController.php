<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isPost())
        {
            return 'Handle submitted data';
        }

        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $User = new User();

        if($request->isPost())
        {
            $User->loadData($request->getBody());
            if($User->validate() && $User->register())
            {
                Application::$app->session->setFlash('success', 'Thanks for Registering');
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
}
