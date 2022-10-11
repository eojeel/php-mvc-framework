<?php
namespace app\controllers;

use app\core\Request;
use app\core\Controller;
use app\models\RegisterModel;

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
        $registerModel = new RegisterModel();

        print_r($registerModel);


        if($request->isPost())
        {
            $registerModel->loadData($request->getBody());
            if($registerModel->validate() && $registerModel->register())
            {
                return 'yay';
            }
            return $this->render('register', [
                'model' => $registerModel]
            );
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel]
        );
    }
}
