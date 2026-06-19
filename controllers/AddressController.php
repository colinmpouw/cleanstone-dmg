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