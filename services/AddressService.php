<?php

namespace services;

use Exception;
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

    public function deleteAddress(int $id, int $user_id): bool
    {
        return $this->repository->deleteAddress($id, $user_id);
    }

    public function setDefaultAddress(int $id, int $user_id): void
    {
        $this->repository->resetInvoiceAddresses($user_id);
        $this->repository->changeAddressInvoice(1, $id, $user_id);
    }

    public function createAddress($request)
    {
        $required = [
            'first_name',
            'last_name',
            'street',
            'house_number',
            'postal_code',
            'city',
            'country',
            'phone',
        ];

        foreach ($required as $field) {
            if (empty($request[$field])) {
                throw new Exception("Veld '$field' is verplicht");
            }
        }


        $id = $this->repository->createAddress($request);


        if (!empty($request['invoice_address']) && $request['invoice_address'] == 1) {


            $this->repository->resetInvoiceAddresses($request['user_id']);


            $this->repository->changeAddressInvoice(1, $id, $request['user_id']);
        }

        return $id;
    }

    public function updateAddress(int $id, int $user_id, array $data): bool
    {
        return $this->repository->updateAddress($id, $user_id, $data);
    }

    public function getById(int $id, int $user_id): ?array
    {
        return $this->repository->getById($id, $user_id);
    }
}