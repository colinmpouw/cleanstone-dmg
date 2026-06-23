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
    public function deleteAddress(int $id, int $user_id): bool
    {
        return $this->DB->save(
            "DELETE FROM addresses WHERE id = ? AND user_id = ?",
            [$id, $user_id]
        );
    }

    public function createAddress($input)
    {
        $sql = "INSERT INTO addresses 
    (user_id, first_name, last_name, street, house_number, postal_code, city, country, phone, email, invoice_address) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
            $input['email'] ?? null,
            $input['invoice_address'] ?? 0
        ];

        $this->DB->save($sql, $params);

        return $this->DB->lastInsertId();
    }

    public function changeAddressInvoice($invoice_address, $id, $user_id)
    {
        $sql = "UPDATE addresses 
            SET invoice_address = ? 
            WHERE user_id = ? AND id = ?";

        $params = [$invoice_address, $user_id, $id];

        $this->DB->save($sql, $params);
    }

    public function resetInvoiceAddresses($user_id)
    {
        $sql = "UPDATE addresses SET invoice_address = 0 WHERE user_id = ?";
        $this->DB->save($sql, [$user_id]);
    }
    public function getUserInvoiceAdress($id)
    {
        $sql = "SELECT id FROM addresses WHERE user_id = ? AND invoice_address = 1";
        $result = $this->DB->read($sql, [$id]);
        return $result[0] ?? null;
    }

    public function updateAddress(int $id, int $user_id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE addresses SET 
            first_name = ?, last_name = ?, street = ?, house_number = ?,
            postal_code = ?, city = ?, country = ?, phone = ?
         WHERE id = ? AND user_id = ?",
            [
                $data['first_name'],
                $data['last_name'],
                $data['street'],
                $data['house_number'],
                $data['postal_code'],
                $data['city'],
                $data['country'],
                $data['phone'],
                $id,
                $user_id
            ]
        );
    }

    public function getById(int $id, int $user_id): ?array
    {
        $rows = $this->DB->read(
            "SELECT * FROM addresses WHERE id = ? AND user_id = ?",
            [$id, $user_id]
        );
        return $rows[0] ?? null;
    }
}