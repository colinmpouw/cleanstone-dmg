<?php

namespace repositories;

use controllers\DatabaseController;

class DiscountRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function check_discount($discount)
    {
        $sql = "
    SELECT *
    FROM discount_codes
    WHERE code = :code
      AND status = 'active'
      AND (start_date IS NULL OR start_date <= NOW())
      AND (end_date IS NULL OR end_date >= NOW())
      AND (usage_limit IS NULL OR used_count < usage_limit)
    ";

        $result = $this->DB->read($sql, ['code' => $discount]);

        return $result;
    }

    public function check_user_used_discount($user_id, $discount_id)
    {
        $sql = "
    SELECT id 
    FROM discount_code_usages
    WHERE user_id = :user_id
      AND discount_code_id = :discount_id
    LIMIT 1
    ";

        $result = $this->DB->read($sql, [
            'user_id' => $user_id,
            'discount_id' => $discount_id
        ]);

        return !empty($result);
    }

    public function add_user_usage($userId, $discountId, $orderId)
    {
        $sql = "
        INSERT INTO discount_code_usages 
        (user_id, discount_code_id, order_id)
        VALUES (:user_id, :discount_code_id, :order_id)
    ";

        $params = [
            'user_id' => $userId,
            'discount_code_id' => $discountId,
            'order_id' => $orderId
        ];

        $result = $this->DB->save($sql, $params);
        return $result;
    }

    public function change_discount_used_count($discountId){
        $sql = "
        UPDATE discount_codes 
        SET used_count = used_count + 1
        WHERE id = :discount_id
    ";

        $params = [
            'discount_id' => $discountId
        ];

        $result = $this->DB->save($sql, $params);
        return $result;
    }

}