<?php

namespace adminServices;

use adminRepositories\AdminBundlesRepository;

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