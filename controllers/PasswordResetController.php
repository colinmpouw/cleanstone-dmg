<?php

namespace controllers;
use services\PasswordResetService;

class PasswordResetController
{
    private PasswordResetService $service;

    public function __construct($router)
    {
        $this->service = new PasswordResetService();

        $router->get('/wachtwoord-vergeten', [$this, 'showEmail']);
        $router->post('/api/reset/send-code', [$this, 'sendCode']);
        $router->post('/api/reset/verify-code', [$this, 'verifyCode']);
        $router->post('/api/reset/reset-password', [$this, 'resetPassword']);
    }

    public function showEmail(): void
    {
        require __DIR__ . '/../public/wachtwoord-vergeten.php';
    }

    public function sendCode(): void
    {
        header('Content-Type: application/json');
        $data  = json_decode(file_get_contents('php://input'), true);
        $email = trim($data['email'] ?? '');

        if (!$email) {
            echo json_encode(['success' => false, 'message' => 'Vul uw e-mailadres in.']);
            return;
        }

        $user = $this->service->findUserByEmail($email);
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Geen account gevonden met dit e-mailadres.']);
            return;
        }

        $this->service->sendResetCode($email);

        echo json_encode([
            'success' => true,
            'user_id' => $user['id']
        ]);
        exit;
    }

    public function verifyCode(): void
    {
        header('Content-Type: application/json');
        $data    = json_decode(file_get_contents('php://input'), true);
        $user_id = (int)($data['user_id'] ?? 0);
        $token   = trim($data['token'] ?? '');

        if (!$user_id || !$token) {
            echo json_encode(['success' => false, 'message' => 'Ongeldige gegevensController.']);
            return;
        }

        $valid = $this->service->verifyCode($user_id, $token);
        echo json_encode(['success' => $valid, 'message' => $valid ? 'Code correct.' : 'Ongeldige of verlopen code.']);
        exit;
    }

    public function resetPassword(): void
    {
        header('Content-Type: application/json');
        $data     = json_decode(file_get_contents('php://input'), true);
        $user_id  = (int)($data['user_id'] ?? 0);
        $token    = trim($data['token'] ?? '');
        $password = trim($data['password'] ?? '');

        if (!$user_id || !$token || strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Ongeldige gegevensController.']);
            return;
        }

        $success = $this->service->resetPassword($user_id, $token, $password);
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Wachtwoord succesvol gewijzigd.' : 'Code ongeldig of verlopen.'
        ]);
        exit;
    }
}