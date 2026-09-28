<?php

namespace App\Middleware;

use Easysite\Library\Auth;
use Easysite\Library\Controller;
use Easysite\Library\Middleware;

/**
 * Global ('global' in config/middleware.php): on every request, hands the controller
 * $this->auth and the layout navbar the current user. If the route declares
 * 'middleware' => ['auth' => ['role' => 'user']] it also only lets a matching role
 * through, redirecting to /login otherwise.
 */
class AuthMiddleware extends Middleware
{
    public function handle(Controller $controller, mixed $params): bool
    {
        $auth = new Auth($this->dbRepository->getRepository('first'));
        $controller->auth = $auth;
        $controller->view->pageElement->setAuthUser($auth->user());

        if ($params === null) {
            return true;
        }

        $role = is_array($params) ? ($params['role'] ?? 'user') : 'user';
        if ($auth->hasRole($role)) {
            return true;
        }

        return $this->redirect('/login?next=' . urlencode('/' . $controller->getRequest()->getRequestUri()));
    }
}
