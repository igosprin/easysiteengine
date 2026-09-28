<?php
use Easysite\Library\Controller;
use Easysite\Library\Log;

class errorController extends Controller
{
    public function error404(string $message = 'Not found')
    {
        Log::error('404: ' . $message);
        http_response_code(404);
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('404');
        $this->view->render('error/404.html', ['message' => 'Page not found']);
    }
}
