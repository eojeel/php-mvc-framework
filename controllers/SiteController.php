<?php
namespace app\controllers;

use app\core\Request;
use app\core\Controller;
/**
 * Undocumented class
 */
class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home', ['name' => 'Joe Lee']);
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        return 'Handling submitted data';
    }
}
