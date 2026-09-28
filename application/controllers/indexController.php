<?php

use Easysite\Library\Controller;

/** Placeholder homepage — Route::searchEvent() defaults an empty URL to index/index. */
class indexController extends Controller
{
    public function indexAction()
    {
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('Home');
        $this->view->render('index/start.html');
    }
}
