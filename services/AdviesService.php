<?php

namespace services;
use PHPMailer\PHPMailer\PHPMailer;
use repositories\AdviesRepository;
use services\MailService;

class AdviesService
{
    private AdviesRepository $repository;
    private MailService $mail;

    public function __construct()
    {
        $this->repository = new AdviesRepository();
        $this->mail = new MailService();
    }

    public function createRequest(array $data): int
    {

        $this->mail->sendAdviesBevestiging($data['email'], $data['name']);


        return $this->repository->createRequest($data);
    }

    public function saveImage(int $request_id, string $filename): void
    {
        $this->repository->saveImage($request_id, $filename);
    }

    public function deleteRequest(int $id, int $user_id): bool
    {
        return $this->repository->deleteRequest($id, $user_id);
    }

    public function getRequestById(int $id): ?array
    {
        return $this->repository->getRequestById($id);
    }

    public function getImages(int $request_id): array
    {
        return $this->repository->getImages($request_id);
    }

    public function getRequestsByUser(int $user_id): array
    {
        return $this->repository->getRequestsByUser($user_id);
    }

    public function getMessages(int $request_id): array
    {
        return $this->repository->getMessages($request_id);
    }

    public function sendMessage(int $request_id, int $user_id, string $message): void
    {
        $this->repository->sendMessage($request_id, $user_id, $message);
    }

    public function updateStatus(int $id, string $status): void
    {
        $this->repository->updateStatus($id, $status);
    }
}