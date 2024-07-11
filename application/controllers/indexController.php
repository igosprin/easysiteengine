<?php
use Easysite\Library\Controller;

class indexController extends Controller
{

    public function indexAction()
    {
        $this->view->setLayout('layout/index.html');
        $data = ['one' => 'ii', 'two' => '2'];
        $this->view->setTitle('start::index');

        $this->view->render('index/start.html', $data);

    }

}