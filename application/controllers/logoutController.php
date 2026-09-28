<?php

use Easysite\Library\Controller;

class logoutController extends Controller
{
    /** GET /logout */
    public function indexAction()
    {
        $this->auth->logout();
        header('Location: /');
    }
}
