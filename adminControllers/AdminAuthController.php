<?php

namespace adminControllers;
use repositories\UserRepository;

class AdminAuthController
{
    private UserRepository $userRepository;

    public function __construct($router)
    {
        $this->userRepository = new UserRepository();

        $router->get('/admin/login', [$this, 'showLogin']);
        $router->post('/admin/login', [$this, 'processLogin']);
        $router->get('/admin/logout', [$this, 'logout']);
    }

    public function showLogin(): void
    {
        if ($this->isAdminLoggedIn()) {
            header('Location: /admin');
            exit;
        }
        require __DIR__ . '/../admin/adminLogin.php';
    }

    public function processLogin(): void
    {
        $errors = [];
        $email    = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if ($email === '') $errors[] = 'Vul uw e-mailadres in.';
        if ($password === '') $errors[] = 'Vul uw wachtwoord in.';

        $user = null;
        if (empty($errors)) {
            $user = $this->userRepository->findByEmail($email);

            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors[] = 'Ongeldig e-mailadres of wachtwoord.';
            } elseif ($user['role'] !== 'admin') {
                $errors[] = 'U heeft geen toegang tot het beheerpaneel.';
            }
        }

        if (!empty($errors)) {
            $errorMessage = $errors[0];
            require __DIR__ . '/../admin/adminLogin.php';
            return;
        }

        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'role'     => $user['role'],
        ];

        header('Location: /admin');
        exit;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: /admin/login');
        exit;
    }

    private function isAdminLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']) && $_SESSION['user']['role'] === 'admin';
    }
}