<?php

namespace controllers;
use services\ReviewsService;

class ReviewsController
{
    private ReviewsService $service;

    public function __construct($router)
    {
        $this->service = new ReviewsService();

        $router->get('/account/mijn-reviews', [$this, 'page']);
        $router->get('/mijn-reviews', [$this, 'page']);
        $router->get('/api/mijn-reviews', [$this, 'getAll']);
        $router->post('/api/mijn-reviews/update', [$this, 'update']);
        $router->post('/api/mijn-reviews/delete', [$this, 'delete']);
    }

    private function requireLogin(): void
    {
        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function page(): void
    {
        $this->requireLogin();
        require __DIR__ . '/../public/mijn-reviews.php';
    }

    public function getAll(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');
        $reviews = $this->service->getByUser($_SESSION['user']['id']);
        echo json_encode(['success' => true, 'data' => $reviews]);
        exit;
    }

    public function update(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $data   = json_decode(file_get_contents('php://input'), true);
        $id     = (int)($data['id'] ?? 0);
        $rating = (int)($data['rating'] ?? 0);
        $review = trim($data['review'] ?? '');

        if (!$id || !$rating || !$review) {
            echo json_encode(['success' => false, 'message' => 'Vul alle velden in']);
            return;
        }

        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Rating moet tussen 1 en 5 zijn']);
            return;
        }

        $success = $this->service->update($id, $_SESSION['user']['id'], $rating, $review);
        echo json_encode(['success' => $success, 'message' => $success ? 'Review bijgewerkt' : 'Bijwerken mislukt']);
        exit;
    }

    public function delete(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) { echo json_encode(['success' => false]); return; }

        $success = $this->service->delete($id, $_SESSION['user']['id']);
        echo json_encode(['success' => $success, 'message' => $success ? 'Review verwijderd' : 'Verwijderen mislukt']);
        exit;
    }
}