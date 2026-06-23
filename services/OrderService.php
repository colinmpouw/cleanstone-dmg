<?php

namespace services;

use Exception;
use repositories\AddressRepository;
use repositories\CartRepository;
use repositories\DiscountRepository;
use repositories\OrderRepository;

class OrderService
{
    private $orderRepository;
    private $addressRepository;
    private $cartRepository;
    private $discountRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->addressRepository = new AddressRepository();
        $this->cartRepository = new CartRepository();
        $this->discountRepository = new DiscountRepository();
    }

    public function placeOrder($userId, $data): void
    {
        $required = ['address_id', 'payment', 'shipping'];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("Veld '$field' is verplicht");
            }
        }

        // ✅ Get invoice address
        $invoiceAddress = $this->addressRepository->getUserInvoiceAdress($userId);

        // ✅ Get cart items
        $products = $this->cartRepository->getCartItems($userId);

        if (empty($products)) {
            throw new Exception("Winkelwagen is leeg");
        }

        $subtotal = 0;
        $hasBundles = false;

        foreach ($products as $product) {

            // ✅ STOCK CHECK
            if (!$product['bundle_id'] && $product['stock'] < $product['quantity']) {
                throw new Exception("Product {$product['product_id']} out of stock");
            }

            // ✅ Use price directly from view
            $price = $product['bundle_id']
                ? $product['bundle_price']
                : $product['product_price'];

            $subtotal += $price * $product['quantity'];

            // ✅ bundle detection
            if (!empty($product['bundle_id'])) {
                $hasBundles = true;
            }
        }

        // ✅ DISCOUNT LOGIC (same as frontend)
        $discountAmount = 0;
        $discountId = null;

        if (!empty($data['discount'])) {
            $discount = $this->discountRepository->check_discount($data['discount']);
            $discount = $discount[0];
            $discountId = $discount['id'];
            if ($discount) {
                $meetsMin = !$discount['min_order_amount'];

                if ($meetsMin) {


                    if ($discount['type'] === 'percentage') {
                        $discountAmount = $subtotal * ($discount['value'] / 100);

                        if (!empty($discount['max_discount'])) {
                            $discountAmount = min($discountAmount, $discount['max_discount']);
                        }
                    } else {
                        $discountAmount = $discount['value'];
                    }
                }
            }
        }

        $deliveryPrice = 0;
        if ($subtotal <= 50) {
            if ($data['shipping'] == 'postnl standaard') {
                $deliveryPrice = 5.95;
            } elseif ($data['shipping'] == 'postnl express') {
                $deliveryPrice = 9.95;
            } elseif ($data['shipping'] == 'dhl express') {
                $deliveryPrice = 12.95;
            }
        }

        // ✅ FINAL TOTAL
        $total = ($subtotal - $discountAmount) + $deliveryPrice;

        // ✅ Prepare order
        $orderData = [
            'total_price' => $total,
            'status' => 'pending',
            'payment_method' => $data['payment'],
            'delivery_option' => $data['shipping'],
            'delivery_price' => $deliveryPrice,
            'shipping_address_id' => $data['address_id'],
            'invoice_address_id' => $invoiceAddress['id'] ?? null,
            'discount_code_id' => $discountId,
            'discount_amount' => $discountAmount,
            'has_bundle' => $hasBundles ? 1 : 0,
        ];

        try {

            $orderId = $this->orderRepository->createOrder($userId, $orderData);

            foreach ($products as $product) {

                $isBundle = !empty($product['bundle_id']);

                $price = $isBundle
                    ? $product['bundle_price']
                    : $product['product_price'];

                if (!$isBundle) {
                    $this->orderRepository->addOrderItem([
                        'order_id' => $orderId,
                        'product_id' => $product['product_id'],
                        'price' => $price,
                        'quantity' => $product['quantity'],
                    ]);
                } else {
                    $this->orderRepository->addOrderBundle([
                        'order_id' => $orderId,
                        'bundle_id' => $product['bundle_id'],
                        'price' => $price,
                        'quantity' => $product['quantity'],
                    ]);
                }
            }

            $paymentSuccess = $this->fakePayment($total);

            if (!$paymentSuccess) {


                $this->orderRepository->updateOrderStatus($orderId, 'failed');

                throw new Exception("Betaling mislukt");
            }

            
            if (!empty($discountId)) {
                $this->discountRepository->add_user_usage($userId, $discountId, $orderId);
                $this->discountRepository->change_discount_used_count($discountId);
            }

            $this->orderRepository->updateOrderStatus($orderId, 'paid');

            $this->cartRepository->clearCart($userId);

        } catch (Exception $e) {

            $this->debugLog('Error: ', explode("\n", $e->getMessage()));
            throw new Exception($e->getMessage());
        }
    }

    function debugLog($label, $data): void
    {
        $entry = '[' . date('Y-m-d H:i:s') . '] ' . $label . ': ' . print_r($data, true) . PHP_EOL;
        file_put_contents(__DIR__ . '/../debug.log', $entry, FILE_APPEND);
    }
    private function fakePayment($amount)
    {
        return rand(1, 10) <= 9;
    }

}