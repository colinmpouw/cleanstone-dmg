<?php

namespace services;
use repositories\BundlesRepository;
class BundlesService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BundlesRepository();
    }

    public function get_top_bundles()
    {
        $bundleRows = $this->repository->get_top_bundles();

        if (empty($bundleRows)) return [];

        $result = [];

        foreach ($bundleRows as $rows) {
            $result[] = $this->buildBundles($rows)[0];
        }

        return $result;
    }
    public function get_all_bundles()
    {
        $rows = $this->repository->get_all_bundles();

        return $this->buildBundles($rows);
    }
    public function find_bundles_by_similar($bundle_id,$bundle_name)
    {

        $rows = $this->repository->find_bundles_by_similar($bundle_id,$bundle_name);
        return $this->buildBundles($rows);
    }
    public function find_bundle($bundle_id)
    {
        $rows = $this->repository->find_bundle($bundle_id);
        $bundles = $this->buildBundles($rows);

        return $bundles[0] ?? null;
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
                    "slug" => $row['product_slug'],
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
