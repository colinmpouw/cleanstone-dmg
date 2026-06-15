<?php

namespace controllers;
use services\AdviesService;

class AdviesController
{
    private AdviesService $adviesService;

    public function __construct($router)
    {
        $this->adviesService = new AdviesService();

        $router->get('/advies', [$this, 'pageAdvies']);
        $router->get('/show-advies', [$this, 'pageShowAdvies']);
        $router->post('/api/advies/submit', [$this, 'submitForm']);
    }

    private function requireLogin(): void
    {
        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function pageAdvies(): void
    {
        require __DIR__ . '/../public/advies.php';
    }

    public function pageShowAdvies(): void
    {
        require __DIR__ . '/../public/show-advies.php';
    }

    public function submitForm(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $user = $_SESSION['user'];

        $request_id = $this->adviesService->createRequest([
            'user_id'        => $user['id'],
            'name'           => trim($_POST['name'] ?? ''),
            'email'          => trim($_POST['email'] ?? ''),
            'phone'          => trim($_POST['phone'] ?? ''),
            'stone_type'     => trim($_POST['stone_type'] ?? ''),
            'stone_location' => trim($_POST['stone_location'] ?? ''),
            'message'        => trim($_POST['message'] ?? ''),
        ]);

        if (!$request_id) {
            echo json_encode(['success' => false, 'message' => 'Aanmaken mislukt']);
            return;
        }

        if (!empty($_FILES['photos']['name'][0])) {
            $uploadDir = __DIR__ . '/../uploads/advies/';
            $allowed   = ['jpg', 'jpeg', 'png', 'heic', 'webp'];

            foreach ($_FILES['photos']['tmp_name'] as $i => $tmp) {
                if ($_FILES['photos']['error'][$i] !== UPLOAD_ERR_OK) continue;
                $ext = strtolower(pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed)) continue;
                $filename = uniqid('advies_') . '.' . $ext;
                move_uploaded_file($tmp, $uploadDir . $filename);
                $this->adviesService->saveImage($request_id, $filename);
            }
        }

        echo json_encode(['success' => true, 'request_id' => $request_id]);
        exit;
    }
}