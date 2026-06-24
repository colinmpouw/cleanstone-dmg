<?php

namespace controllers;

use services\AddressService;
class AddressController
{

    private $addressService;
    public function __construct($router)
    {
        $this->addressService = new AddressService();
        $router->get('/api/get_all_addresses', [$this, 'getAll']);
        $router->post('/api/add_address', [$this, 'create']);
        $router->get('/adressen', [$this, 'ShowAdressen']);
        $router->post('/api/adressen/delete', [$this, 'delete']);
        $router->post('/api/adressen/default', [$this, 'setDefault']);
        $router->get('/account/adressen', [$this, 'ShowAdressen']);
        $router->get('/api/adressen/{id}', [$this, 'getOne']);
        $router->post('/api/adressen/update', [$this, 'update']);
    }

    public function ShowAdressen()
    {
        require __DIR__ . '/../public/adressen.php';
    }


    public function getAll(): void
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Niet ingelogd']);
            return;
        }

        try {
            $addresses = $this->addressService->getAddressByUser((int) $userId);
            echo json_encode(['success' => true, 'data' => $addresses]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Kon adressen niet laden']);
        }
    }

    public function delete(): void
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) { echo json_encode(['success' => false]); return; }

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) { echo json_encode(['success' => false]); return; }

        $success = $this->addressService->deleteAddress($id, (int)$userId);
        echo json_encode(['success' => $success]);
        exit;
    }

    public function setDefault(): void
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) { echo json_encode(['success' => false]); return; }

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) { echo json_encode(['success' => false]); return; }

        $this->addressService->setDefaultAddress($id, (int)$userId);
        echo json_encode(['success' => true]);
        exit;
    }

    public function getOne(string $id): void
    {
        header('Content-Type: application/json');
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) { echo json_encode(['success' => false]); return; }

        $address = $this->addressService->getById((int)$id, (int)$userId);
        if (!$address) { echo json_encode(['success' => false, 'message' => 'Niet gevonden']); return; }

        echo json_encode(['success' => true, 'data' => $address]);
        exit;
    }

    public function update(): void
    {
        header('Content-Type: application/json');
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) { echo json_encode(['success' => false, 'message' => 'Niet ingelogd']); return; }

        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);

        if (!$id) { echo json_encode(['success' => false, 'message' => 'Ongeldig ID']); return; }

        $required = ['first_name', 'last_name', 'street', 'house_number', 'postal_code', 'city', 'country', 'phone', 'email'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'message' => "Veld '$field' is verplicht"]);
                return;
            }
        }

        $success = $this->addressService->updateAddress($id, (int)$userId, $data);
        echo json_encode(['success' => $success, 'message' => $success ? 'Adres bijgewerkt' : 'Bijwerken mislukt']);
        exit;
    }

    public function create(): void
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Niet ingelogd']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);


        $input['user_id'] = $userId;

        try {
            $id = $this->addressService->createAddress($input);

            echo json_encode([
                'success' => true,
                'data' => ['id' => $id]
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage() // ✅ show real validation error
            ]);
        }
    }
}