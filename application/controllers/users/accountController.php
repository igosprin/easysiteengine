<?php

use Easysite\Library\Controller;

/**
 * Example placeholder under application/controllers/users/ — demonstrates the auth
 * base end to end (AuthMiddleware, the route's 'middleware' => ['auth' => [...]],
 * the 'dir' route key, remember-cookie session restore). Replace with real pages.
 */
class accountController extends Controller
{
    /** GET /account — requires the 'auth' middleware with role=user (config/routs.php) */
    public function showAction()
    {
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('Account');
        $this->view->render('account/show.html', [
            'user' => $this->auth->user(),
        ]);
    }
}
