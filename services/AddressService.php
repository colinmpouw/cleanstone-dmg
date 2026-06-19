<?php

namespace services;

use repositories\AddressRepository;

class AddressService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AddressRepository();
    }

    public function getAddressByUser($userId)
    {
        return $this->repository->getAddressByUser($userId);
    }
    public function createAddress($request)
    {
        $required = ['first_name', 'last_name', 'street', 'house_number', 'postal_code', 'city', 'country', 'phone'];

        foreach ($required as $field) {
            if (empty($request[$field])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Veld '$field' is verplicht"
                ]);
                return;
            }
        }

        return $this->repository->createAddress($request);
    }
}