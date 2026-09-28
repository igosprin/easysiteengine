<?php

use App\Models\UsesModels;
use Easysite\Library\Controller;

class loginController extends Controller
{
    use UsesModels;

    /** GET /login[?next=/some/path] */
    public function showAction()
    {
        if ($this->auth->check()) {
            header('Location: /');
            return;
        }

        $this->render();
    }

    /** POST /login/submit */
    public function submitAction()
    {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $remember = !empty($_POST['remember']);
        $next = (string) ($_POST['next'] ?? '');

        $user = $email !== '' ? $this->model('User')->findByEmail($email) : null;
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->render('Wrong email or password', $email);
            return;
        }

        $this->auth->login((int) $user['id'], $remember);
        header('Location: ' . ($this->safeNext($next) ?: '/'));
    }

    private function render(?string $error = null, string $email = ''): void
    {
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('Log in');
        $this->view->render('login/show.html', [
            'error' => $error,
            'email' => $email,
            'next'  => (string) ($_GET['next'] ?? ''),
        ]);
    }

    /** Own path only — not an open redirect to another host. */
    private function safeNext(string $next): ?string
    {
        return ($next !== '' && str_starts_with($next, '/') && !str_starts_with($next, '//')) ? $next : null;
    }
}
