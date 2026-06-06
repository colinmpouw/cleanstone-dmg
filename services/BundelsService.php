<?php

namespace services;
use repositories\BundelsRepository;
class BundelsService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BundelsRepository();
    }


    public function get_all_bundels()
    {
        $rows = $this->repository->get_all_bundels();

        if (empty($rows)) {
            return [];
        }

        $bundels = [];
        $seen = [];

        foreach ($rows as $row) {

            $id = $row['bundle_id'];

            if (!isset($bundels[$id])) {
                $bundels[$id] = [
                    "id" => $id,
                    "name" => $row['name'],
                    "description" => $row['description'],
                    "price" => $row['price'],
                    "image" => $row['image'],
                    "created_at" => $row['created_at'],
                    "products" => []

                ];
            }


            $productKey = $row['product_id'];

            if (!isset($seen[$id][$productKey])) {

                $bundels[$id]['products'][] = [
                    "product_id" => $row['product_id'],
                    "product_name" => $row['product_name'],
                    "quantity" => $row['quantity']
                ];

                $seen[$id][$productKey] = true;
            }
        }

        return array_values($bundels);
    }

}
