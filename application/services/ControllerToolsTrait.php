<?php

namespace App\Services;

/** Small controller helpers. Requires $this->view (available on Easysite\Library\Controller). */
trait ControllerToolsTrait
{
    /** 404 page with a message; the controller should return right after calling this. */
    protected function notFound(string $message): void
    {
        http_response_code(404);
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('404');
        $this->view->render('error/404.html', ['message' => $message]);
    }
}
