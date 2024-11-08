<?php
use Easysite\Library\Config;
use Easysite\Library\Controller;
use Easysite\Library\Instance\Cache;

class indexController extends Controller
{

    public function indexAction()
    {
        var_dump(Config:: get('session')->getAliase());        
        $this->view->setLayout('layout/index.html');
        $cachKey='pron';
        
        if(Cache::isset($cachKey)){
            echo 'from_cashe';
            $data= Cache::get($cachKey);
        }            
        else{            
            $data = ['one' => 'ii', 'two' => '2'];
            Cache::set($cachKey,$data,20);
        } 
        
        $this->view->setTitle('start::index');

        $this->view->render('index/start.html', $data);

    }
    public function getAction()
    {
        var_dump(Config:: get('session')->getAliase());        
        $this->view->setLayout('layout/index.html');
        $cachKey='pron';
        
        $data =Cache::make($cachKey,function(){
            return  ['one' => 'ii', 'two' => '2'];
        },20);
        var_dump($data);
        $this->view->setTitle('compa::get');

        $this->view->render('index/start.html', $data);

    }

}