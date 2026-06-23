<?php

namespace services;

use repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function showLogin(): void
    {
        if ($this->isLoggedIn()) {
            header('Location: /account');
            exit;
        }

        require __DIR__ . '/../public/login.php';
    }

    public function processLogin(): void
    {
        $errors = [];
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if ($email === '') {
            $errors[] = 'Vul uw e-mailadres in.';
        }

        if ($password === '') {
            $errors[] = 'Vul uw wachtwoord in.';
        }

        $user = null;
        if (empty($errors)) {
            $user = $this->userRepository->findByEmail($email);

            if (!$user || !$this->verifyPassword($password, $user['password_hash'])) {
                $errors[] = 'Ongeldig e-mailadres of wachtwoord.';
            }
        }

        if (!empty($errors)) {
            $oldEmail = htmlspecialchars($email);
            require __DIR__ . '/../public/login.php';
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        header('Location: /account');
        exit;
    }

    public function showRegister(): void
    {
        if ($this->isLoggedIn()) {
            header('Location: /account');
            exit;
        }

        require __DIR__ . '/../public/register.php';
    }

    public function processRegister(): void
    {
        $errors = [];
        $username = trim($_POST['username'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($username === '') {
            $errors[] = 'Vul uw gebruikersnaam in.';
        }
        if ($email === '') {
            $errors[] = 'Vul uw e-mailadres in.';
        }
        if ($password === '') {
            $errors[] = 'Vul uw wachtwoord in.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Wachtwoorden komen niet overeen.';
        }

        if ($this->userRepository->findByEmail($email)) {
            $errors[] = 'Er bestaat al een account met dit e-mailadres.';
        }

        if ($this->userRepository->findByUsername($username)) {
            $errors[] = 'Deze gebruikersnaam is al in gebruik.';
        }

        if (!empty($errors)) {
            $oldUsername = htmlspecialchars($username);
            $oldEmail = htmlspecialchars($email);
            require __DIR__ . '/../public/register.php';
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->userRepository->createUser([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => 'customer',
        ]);

        if (!$userId) {
            $errors[] = 'Kon uw account niet aanmaken. Probeer het later opnieuw.';
            $oldUsername = htmlspecialchars($username);
            $oldEmail = htmlspecialchars($email);
            require __DIR__ . '/../public/register.php';
            return;
        }

        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
            'email' => $email,
            'role' => 'customer',
        ];

        // welkom mail
        $mailService = new \services\MailService();
        $mailService->sendWelkomMail($email, $username);

        header('Location: /account');
        exit;
    }

    public function showAccount(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $user = $this->userRepository->findById($_SESSION['user']['id']);

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        $accountService = new \services\AccountService();
        $accountData    = $accountService->getAccountData($user['id']);

        require __DIR__ . '/../public/account-overzicht.php';
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']);
    }

    private function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash) || $password === $hash;
    }

    public function getAccountData(): void
    {
        if (!$this->isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false]);
            return;
        }

        $accountService = new \services\AccountService();
        $data = $accountService->getAccountData($_SESSION['user']['id']);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $data]);
        exit;
    }
}