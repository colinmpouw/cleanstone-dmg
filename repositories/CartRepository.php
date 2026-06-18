<?php

namespace repositories;

use controllers\DatabaseController;

class CartRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getCartItems($user_id)
    {
        $sql = "
SELECT *
FROM cart_products_details
WHERE user_id = :user_id;

";
        $params = [':user_id' => $user_id];
        return $this->DB->read($sql, $params);
    }
}