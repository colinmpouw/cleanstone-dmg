<?php

namespace services;

use repositories\ProductenRepository;

class ProductenService
{
    private ProductenRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductenRepository();
    }

    public function getAllProducts(): array
    {
        $rows= $this->repository->getAllProducts();
        return $this->groupProductRows($rows);
    }
    private function groupProductRows(array $rows): array
{
    $products = [];

    foreach ($rows as $row) {
        $id = $row['id'];

        if (!isset($products[$id])) {
            $products[$id] = [
                'id' => $row['id'],
                'slug' => $row['slug'],
                'name' => $row['name'],
                'sku' => $row['sku'],
                'description' => $row['description'],
                'short_description' => $row['short_description'],
                'price' => $row['price'],
                'sale_price' => $row['sale_price'],
                'stock' => $row['stock'],
                'image' => $row['image'],
                'created_at' => $row['created_at'],
                'category' => [
                    'name' => $row['category_name'],
                    'slug' => $row['category_slug'],
                ],
                'brand' => [
                    'name' => $row['brand_name'],
                    'logo' => $row['brand_logo'],
                ],
                'avg_rating' => $row['avg_rating'],
                'review_count' => $row['review_count'],
                'tags' => [],
                'images' => [],
            ];
        }

        if (!empty($row['tag_id']) && !isset($products[$id]['tags'][$row['tag_id']])) {
            $products[$id]['tags'][$row['tag_id']] = [
                'id' => $row['tag_id'],
                'name' => $row['tag_name'],
            ];
        }

        if (!empty($row['image_id']) && !isset($products[$id]['images'][$row['image_id']])) {
            $products[$id]['images'][$row['image_id']] = [
                'id' => $row['image_id'],
                'image' => $row['image_path'],
                'is_primary' => (bool) $row['is_primary'],
            ];
        }
    }

    // reindex tags/images from assoc (keyed by id) to plain arrays
    foreach ($products as &$product) {
        $product['tags'] = array_values($product['tags']);
        $product['images'] = array_values($product['images']);
    }

    return array_values($products);
}

    public function getCategories(): array
    {
        return $this->repository->getCategories();
    }

    public function getBrands(): array
    {
        return $this->repository->getBrands();
    }

    public function getTopProducts(): array
    {
        return $this->repository->getTopProducts();
    }

    public function searchProductsForAi(string $searchTerm): array
    {
        $rows = $this->repository->searchProductsForAi($searchTerm);
        return $this->buildSimpleProducts($rows);
    }

    public function getTopProductsForAi(): array
    {
        $rows = $this->repository->getTopProductsForAi();
        return $this->buildSimpleProducts($rows);
    }

    private function buildSimpleProducts($rows)
    {
        if (empty($rows)) {
            return [];
        }

        return array_map(function ($row) {
            return [
                "id" => $row['id'],
                "name" => $row['name'],
                "price" => $row['price'],
                "avg_rating" => $row['avg_rating'] ?? null,
                "review_count" => $row['review_count'] ?? 0
            ];
        }, $rows);
    }
}
