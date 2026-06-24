<?php

namespace services;
use repositories\PasswordResetRepository;
use repositories\UserRepository;

class PasswordResetService
{
    private PasswordResetRepository $resetRepo;
    private UserRepository $userRepo;
    private MailService $mailService;

    public function __construct()
    {
        $this->resetRepo   = new PasswordResetRepository();
        $this->userRepo    = new UserRepository();
        $this->mailService = new MailService();
    }

    public function sendResetCode(string $email): bool
    {
        $user = $this->userRepo->findByEmail($email);
        if (!$user) return false;

        $token = strval(random_int(100000, 999999));
        $this->resetRepo->createToken($user['id'], $token);
        $this->mailService->sendResetCode($email, $user['username'], $token);

        return true;
    }

    public function verifyCode(int $user_id, string $token): bool
    {
        return $this->resetRepo->findToken($user_id, $token) !== null;
    }

    public function resetPassword(int $user_id, string $token, string $newPassword): bool
    {
        if (!$this->verifyCode($user_id, $token)) return false;

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userRepo->updatePassword($user_id, $hash);
        $this->resetRepo->deleteToken($user_id);

        return true;
    }

    public function findUserByEmail(string $email): ?array
    {
        return $this->userRepo->findByEmail($email);
    }
}