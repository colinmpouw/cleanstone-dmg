<?php

namespace adminControllers;
use adminServices\AdminDiscountService;

class AdminDiscountController
{
    private AdminDiscountService $service;

    public function __construct($router)
    {
        $this->service = new AdminDiscountService();

        $router->get('/admin/discount-codes', [$this, 'DiscountPage']);
        $router->get('/api/admin/discount-codes', [$this, 'getAll']);
        $router->post('/api/admin/discount-codes', [$this, 'create']);
        $router->put('/api/admin/discount-codes/{id}', [$this, 'update']);
        $router->delete('/api/admin/discount-codes/{id}', [$this, 'delete']);
        $router->post('/api/admin/discount-codes/{id}/toggle', [$this, 'toggleStatus']);
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }

    public function DiscountPage(): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminDiscountCodes.php';
    }

    public function getAll(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $codes = $this->service->getAll();
        echo json_encode(['success' => true, 'data' => $codes, 'count' => count($codes)]);
        exit;
    }

    public function create(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $required = ['code', 'type', 'value'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'message' => "Veld '$field' is verplicht"]);
                return;
            }
        }

        $id = $this->service->create([
            'code'             => strtoupper(trim($data['code'])),
            'type'             => $data['type'],
            'value'            => $data['value'],
            'min_order_amount' => $data['min_order_amount'] ?: null,
            'max_discount'     => $data['max_discount'] ?: null,
            'usage_limit'      => $data['usage_limit'] ?: null,
            'start_date'       => $data['start_date'] ?: null,
            'end_date'         => $data['end_date'] ?: null,
            'status'           => $data['status'] ?? 'active',
        ]);

        echo json_encode(['success' => true, 'id' => $id]);
        exit;
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $success = $this->service->update((int)$id, [
            'code'             => strtoupper(trim($data['code'])),
            'type'             => $data['type'],
            'value'            => $data['value'],
            'min_order_amount' => $data['min_order_amount'] ?: null,
            'max_discount'     => $data['max_discount'] ?: null,
            'usage_limit'      => $data['usage_limit'] ?: null,
            'start_date'       => $data['start_date'] ?: null,
            'end_date'         => $data['end_date'] ?: null,
            'status'           => $data['status'] ?? 'active',
        ]);

        echo json_encode(['success' => $success]);
        exit;
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $success = $this->service->delete((int)$id);
        echo json_encode(['success' => $success]);
        exit;
    }

    public function toggleStatus(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $status  = $data['status'] ?? 'active';
        $success = $this->service->toggleStatus((int)$id, $status);

        echo json_encode(['success' => $success]);
        exit;
    }
}