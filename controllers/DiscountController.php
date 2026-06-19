<?php

namespace controllers;


use services\DiscountService;

class DiscountController
{
    private $discountService;

    public function __construct($router)
    {
        $this->discountService = new DiscountService();
        $router->post('/api/check_discount', [$this, 'check_discount']);

    }


    public function check_discount()
    {
        $discount = $_POST['discount'];
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {

            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;

        }
        if ($discount === null || empty($discount)) {
            echo json_encode(['success' => false, 'message' => 'Discount is required']);
            return;
        }
        $result = $this->discountService->check_discount($discount);

        $user_usage=$this->discountService->check_user_used_discount($userId, $result[0]['id'] ?? null);
        if (empty($result)) {
            echo json_encode(['success' => false, 'message' => 'Discount not found or not valid']);
            return;
        }
        if ($user_usage) {
            echo json_encode(['success' => false, 'message' => 'Discount already used by user']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'Discount checked successfully', 'data' => $result[0]]);

    }
}