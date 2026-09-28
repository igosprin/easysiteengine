<?php

use App\Models\UsesModels;
use Easysite\Library\Controller;

class registerController extends Controller
{
    use UsesModels;

    private const MIN_PASSWORD = 8;

    /** GET /register */
    public function showAction()
    {
        if ($this->auth->check()) {
            header('Location: /');
            return;
        }

        $this->render();
    }

    /** POST /register/submit */
    public function submitAction()
    {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $name = trim((string) ($_POST['name'] ?? ''));

        $error = $this->validate($email, $password, $name);
        if ($error !== null) {
            $this->render($error, $email, $name);
            return;
        }

        $userId = $this->model('User')->create($email, password_hash($password, PASSWORD_DEFAULT), $name);
        $this->auth->login($userId);
        header('Location: /');
    }

    private function validate(string $email, string $password, string $name): ?string
    {
        if ($name === '') {
            return 'Name is required';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Enter a valid email';
        }
        if (strlen($password) < self::MIN_PASSWORD) {
            return 'Password must be at least ' . self::MIN_PASSWORD . ' characters';
        }
        if ($this->model('User')->emailExists($email)) {
            return 'This email is already registered';
        }

        return null;
    }

    private function render(?string $error = null, string $email = '', string $name = ''): void
    {
        $this->view->setLayout('layout/index.html');
        $this->view->setTitle('Register');
        $this->view->render('register/show.html', [
            'error' => $error,
            'email' => $email,
            'name'  => $name,
        ]);
    }
}
