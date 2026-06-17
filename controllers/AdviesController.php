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
        $router->post('/api/advies/submit', [$this, 'submitForm']);
        $router->get('/show-advies/{id}', [$this, 'pageShowAdvies']);
        $router->get('/api/advies/{id}', [$this, 'getRequest']);
        $router->get('/show-advies', [$this, 'pageAdviesOverzicht']);
        $router->get('/api/advies/{id}/messages', [$this, 'getMessages']);
        $router->post('/api/advies/message', [$this, 'sendMessage']);
        $router->post('/api/advies/status', [$this, 'updateStatus']);
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
        $existing = null;
        if (!empty($_SESSION['user']['id'])) {
            $requests = $this->adviesService->getRequestsByUser($_SESSION['user']['id']);
            $existing = $requests[0] ?? null;
        }
        require __DIR__ . '/../public/advies.php';
    }

    public function pageShowAdvies(int $id): void
    {
        $this->requireLogin();
        echo '<script>window.advies_id = ' . json_encode($id) . ';</script>';
        require __DIR__ . '/../public/show-advies.php';
    }

    public function getRequest(int $id): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $request = $this->adviesService->getRequestById($id);

        if (!$request) {
            echo json_encode(['success' => false, 'message' => 'Niet gevonden']);
            return;
        }

        if ($_SESSION['user']['role'] !== 'admin' && $request['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Geen toegang']);
            return;
        }

        $images = $this->adviesService->getImages($id);

        echo json_encode([
            'success' => true,
            'data'    => $request,
            'images'  => $images
        ]);
        exit;
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
    public function pageAdviesOverzicht(): void
    {
        $this->requireLogin();
        $requests = $this->adviesService->getRequestsByUser($_SESSION['user']['id']);

        if (!empty($requests)) {
            header('Location: /show-advies/' . $requests[0]['id']);
            exit;
        }

        // geen aanvraag — laad show-advies met leeg flag
        $no_request = true;
        require __DIR__ . '/../public/show-advies.php';
    }

    public function getMessages(int $id): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $request = $this->adviesService->getRequestById($id);
        if (!$request) { echo json_encode([]); return; }

        if ($_SESSION['user']['role'] !== 'admin' && $request['user_id'] != $_SESSION['user']['id']) {
            echo json_encode([]); return;
        }

        echo json_encode($this->adviesService->getMessages($id));
        exit;
    }

    public function sendMessage(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $data       = json_decode(file_get_contents('php://input'), true);
        $request_id = (int)($data['request_id'] ?? 0);
        $message    = trim($data['message'] ?? '');

        if (!$request_id || $message === '') {
            echo json_encode(['success' => false]); return;
        }

        $request = $this->adviesService->getRequestById($request_id);
        if (!$request) { echo json_encode(['success' => false]); return; }

        if ($_SESSION['user']['role'] !== 'admin' && $request['user_id'] != $_SESSION['user']['id']) {
            echo json_encode(['success' => false, 'message' => 'Geen toegang']); return;
        }

        $this->adviesService->sendMessage($request_id, $_SESSION['user']['id'], $message);
        echo json_encode(['success' => true]);
        exit;
    }

    public function updateStatus(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        if ($_SESSION['user']['role'] !== 'admin') {
            echo json_encode(['success' => false]); return;
        }

        $data   = json_decode(file_get_contents('php://input'), true);
        $id     = (int)($data['id'] ?? 0);
        $status = $data['status'] ?? '';

        if (!$id || !in_array($status, ['open', 'in_behandeling', 'gesloten'])) {
            echo json_encode(['success' => false]); return;
        }

        $this->adviesService->updateStatus($id, $status);
        echo json_encode(['success' => true]);
        exit;
    }
}