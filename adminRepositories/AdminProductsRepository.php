<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminProductsRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAllProducts(): array
    {
        $query = "SELECT * FROM product_summary_view ORDER BY id DESC;";
        return $this->DB->read($query) ?: [];
    }


    public function getProductById(int $id): array
    {
        $query = "
        SELECT *
        FROM products_full_details
        WHERE id = ?
    ";

        return $this->DB->read($query, [$id]);
    }

    public function getCategories(): array
    {
        $query = "SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name";
        return $this->DB->read($query) ?: [];
    }

    public function getBrands(): array
    {
        $query = "SELECT id, name FROM brands ORDER BY name";
        return $this->DB->read($query) ?: [];
    }

    public function getTags()
    {
        $query = "SELECT id, name FROM tags ORDER BY name";
        return $this->DB->read($query) ?: [];
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = ?;";
        return $this->DB->read($query, [$id]);

    }


    public function updateProduct($id, $data)
    {
        $sql = "UPDATE products SET
        name = :name,
        short_description = :short_description,
        description = :description,
        price = :price,
        sale_price = :sale_price,
        stock = :stock,
        sku = :sku,
        brand_id = :brand_id,
        category_id = :category_id
        WHERE id = :id";

        $data['id'] = $id;

        return $this->DB->save($sql, $data);
    }
    public function insertImage($data)
    {
        $url =  $data['image'];

        $this->DB->save(
            "INSERT INTO product_images (product_id, url, image, is_primary)
         VALUES (?, ?, ?, ?)",
            [
                $data['product_id'],
                $url,
                $data['image'],
                $data['is_primary']
            ]
        );

        return [
            'url' => $url,
            'filename' => $data['image']
        ];
    }
    public function clearPrimaryImage($productId)
    {
        $this->DB->save(
            "UPDATE product_images SET is_primary = 0 WHERE product_id = ?",
            [$productId]
        );
    }

    public function syncTags($productId, $tags)
    {
        $this->DB->save(
            "DELETE FROM product_tags WHERE product_id = ?",
            [$productId]
        );

        foreach ($tags as $tagId) {
            $this->DB->save(
                "INSERT INTO product_tags (product_id, tag_id) VALUES (?, ?)",
                [$productId, $tagId]
            );
        }
    }

    public function replaceFeatures($productId, $features)
    {
        $this->DB->save(
            "DELETE FROM product_features WHERE product_id = ?",
            [$productId]
        );

        foreach ($features as $index => $feature) {
            $this->DB->save(
                "INSERT INTO product_features (product_id, feature, display_order)
             VALUES (?, ?, ?)",
                [$productId, $feature, $index + 1]
            );
        }
    }

    public function replaceSpecifications($productId, $specs)
    {
        $this->DB->save(
            "DELETE FROM product_specifications WHERE product_id = ?",
            [$productId]
        );

        foreach ($specs as $index => $spec) {
            $this->DB->save(
                "INSERT INTO product_specifications (product_id, name, value, display_order)
             VALUES (?, ?, ?, ?)",
                [
                    $productId,
                    $spec['name'],
                    $spec['value'],
                    $index + 1
                ]
            );
        }
    }

    public function replaceInstructions($productId, $instructions)
    {
        $this->DB->save(
            "DELETE FROM product_instructions WHERE product_id = ?",
            [$productId]
        );

        foreach ($instructions as $step) {
            $this->DB->save(
                "INSERT INTO product_instructions (product_id, step_number, instruction)
             VALUES (?, ?, ?)",
                [
                    $productId,
                    $step['step'],
                    $step['instruction']
                ]
            );
        }
    }

    public function deleteRemovedImages($productId, $keptIds)
    {
        if (empty($keptIds)) {
            return $this->DB->save(
                "DELETE FROM product_images WHERE product_id = ?",
                [$productId]
            );
        }

        $placeholders = implode(',', array_fill(0, count($keptIds), '?'));

        $sql = "DELETE FROM product_images
            WHERE product_id = ?
            AND id NOT IN ($placeholders)";

        return $this->DB->save(
            $sql,
            array_merge([$productId], $keptIds)
        );
    }

    public function setPrimaryImage($productId, $imageId)
    {
        $this->DB->save(
            "UPDATE product_images SET is_primary = 0 WHERE product_id = ?",
            [$productId]
        );

        return $this->DB->save(
            "UPDATE product_images SET is_primary = 1 WHERE id = ?",
            [$imageId]
        );
    }
}