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
            'email'
        ];

        foreach ($required as $field) {
            if (empty($request[$field])) {
                throw new Exception("Veld '$field' is verplicht");
            }
        }


        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Ongeldig email adres");
        }


        $id = $this->repository->createAddress($request);


        if (!empty($request['invoice_address']) && $request['invoice_address'] == 1) {


            $this->repository->resetInvoiceAddresses($request['user_id']);


            $this->repository->changeAddressInvoice(1, $id, $request['user_id']);
        }

        return $id;
    }
}