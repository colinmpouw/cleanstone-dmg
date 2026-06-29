<?php

namespace adminServices;

use adminRepositories\AdminBundlesRepository;
use Exception;

class AdminBundlesService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminBundlesRepository();
    }


    public function get_all_bundles()
    {
        $rows = $this->repository->get_all_bundles();

        return $this->buildBundles($rows);
    }

    public function find_bundle($bundle_id)
    {
        $rows = $this->repository->find_bundle($bundle_id);

        return $this->buildBundles($rows);
    }
    public function uploadPhoto($bundle_id, $photo)
    {
        // 1. Validate upload
        if (!isset($photo) || $photo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Invalid file upload");
        }

        // 2. Validate file type (important!)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($photo['type'], $allowedTypes)) {
            throw new Exception("Unsupported file type");
        }

        // 3. Generate safe unique filename
        $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('bundle_', true) . '.' . $extension;


        $uploadDir = __DIR__ . '/../uploads/bundles/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $fileName;


        if (!move_uploaded_file($photo['tmp_name'], $destination)) {
            throw new Exception("Failed to save file");
        }


         $this->repository->updatePhoto($bundle_id, $fileName);


        return [
            'bundle_id' => $bundle_id,
            'file_name' => $fileName,
            'path' => '/uploads/bundles/' . $fileName // public URL path
        ];
    }

    public function updateBundle($bundle_id, $data)
    {
        // ✅ 1. validation
        if (empty($data['name'])) {
            throw new Exception("Name is required");
        }

        $name = $data['name'];
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0;
        $bundle_tag = $data['bundle_tag'] ?? '';
        $products = $data['products'] ?? [];

        // ✅ 2. update bundle main info
        $this->repository->updateBundle(
            $bundle_id,
            $name,
            $description,
            $price,
            $bundle_tag
        );

        // ✅ 3. sync products
        $this->repository->deleteBundleProducts($bundle_id);

        foreach ($products as $p) {
            $this->repository->addBundleProduct([
                'bundle_id'   => $bundle_id,
                'product_id'  => $p['product_id'],
                'quantity'    => $p['quantity'],
                'price'       => $p['product_price']
            ]);
        }

        // ✅ 4. 返回
        return [
            "bundle_id" => $bundle_id,
            "updated_products" => count($products)
        ];
    }
    private function buildBundles($rows)
    {
        if (empty($rows)) {
            return [];
        }

        $bundels = [];
        $seenProducts = [];
        $seenTags = [];
        $seenBundleTags = [];

        foreach ($rows as $row) {

            $id = $row['id'];

            if (!isset($bundels[$id])) {
                $bundels[$id] = [
                    "id" => $id,
                    "name" => $row['name'],
                    "description" => $row['description'],
                    "price" => $row['price'],
                    "image" => $row['image'],
                    "created_at" => $row['created_at'],
                    "products" => [],
                    "bundle_tags" => []
                ];

                $seenProducts[$id] = [];
                $seenTags[$id] = [];
                $seenBundleTags[$id] = [];
            }

            $productId = $row['product_id'];

            /* ✅ product */
            if ($productId && !isset($seenProducts[$id][$productId])) {
                $bundels[$id]['products'][$productId] = [
                    "product_id" => $productId,
                    "image" => $row['product_image'],
                    "product_name" => $row['product_name'],
                    "quantity" => $row['quantity'],
                    "price" => $row['product_price'],
                    "rating" => $row['product_avg_rating'],
                    "tags" => []
                ];

                $seenProducts[$id][$productId] = true;
            }

            /* ✅ product tags */
            if ($productId && !empty($row['product_tag_id'])) {

                $tagId = $row['product_tag_id'];

                if (!isset($seenTags[$id][$productId][$tagId])) {

                    $bundels[$id]['products'][$productId]['tags'][] = [
                        "id" => $tagId,
                        "name" => $row['product_tag_name']
                    ];

                    $seenTags[$id][$productId][$tagId] = true;
                }
            }

            /* ✅ bundle tags */
            if (!empty($row['bundle_tag'])) {

                $tag = $row['bundle_tag'];

                if (!isset($seenBundleTags[$id][$tag])) {

                    $bundels[$id]['bundle_tags'][] = $tag;
                    $seenBundleTags[$id][$tag] = true;
                }
            }
        }

        foreach ($bundels as &$bundle) {
            $bundle['products'] = array_values($bundle['products']);
        }

        return array_values($bundels);
    }
}