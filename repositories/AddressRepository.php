<?php

namespace repositories;

use controllers\DatabaseController;

class AddressRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getAddressByUser($userId)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = ?";
        return $this->DB->read($sql, [$userId]);
    }

    public function createAddress($input)
    {
        $sql = "INSERT INTO addresses 
        (user_id, first_name, last_name, street, house_number, postal_code, city, country, phone, invoice_address) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $input['user_id'],
            $input['first_name'],
            $input['last_name'],
            $input['street'],
            $input['house_number'],
            $input['postal_code'],
            $input['city'],
            $input['country'],
            $input['phone'],
            $input['invoice_address'] ?? 0 // default if not provided
        ];

         $this->DB->save($sql, $params);
        return $this->DB->lastInsertId();
    }
}