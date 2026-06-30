<?php

namespace adminServices;

use adminRepositories\AdminProductsRepository;
use Exception;

class AdminProductsService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminProductsRepository();
    }

    public function getAllProducts(): array
    {
        return $this->repository->getAllProducts();
    }
    public function getCategories(): array
    {
        return $this->repository->getCategories();
    }

    public function getBrands(): array
    {
        return $this->repository->getBrands();
    }
    public function getTags(): array
    {
        return $this->repository->getTags();
    }

    public function getProductById($id)
    {
        $rows = $this->repository->getProductById($id);

        return $this->buildProduct($rows);
    }
    public function deleteProduct($id)
    {
        $result=$this->repository->deleteProduct($id);
        return $result;
    }

    public function updateProduct($productId, $data)
    {
        try {

            $this->repository->updateProduct($productId, [
                'name' => $data['name'],
                'short_description' => $data['short_description'],
                'description' => $data['description'],
                'price' => $data['price'],
                'sale_price' => $data['sale_price'],
                'stock' => $data['stock'],
                'sku' => $data['sku'],
                'brand_id' => $data['brand_id'],
                'category_id' => $data['category_id'],
            ]);

            // ✅ TAGS
            $this->repository->syncTags($productId, $data['tags'] ?? []);

            // ✅ FEATURES
            $this->repository->replaceFeatures($productId, $data['features'] ?? []);

            // ✅ SPECS
            $this->repository->replaceSpecifications($productId, $data['specifications'] ?? []);

            // ✅ INSTRUCTIONS
            $this->repository->replaceInstructions($productId, $data['instructions'] ?? []);

            // ✅ ✅ fake image IDs
            $keptIds = array_filter($data['kept_image_ids'] ?? [], function ($id) {
                return is_numeric($id);
            });

            $this->repository->deleteRemovedImages($productId, $keptIds);

            // ✅ ✅ primary image
            $primaryId = !empty($data['primary_image_id']) && is_numeric($data['primary_image_id'])
                ? $data['primary_image_id']
                : null;

            if ($primaryId) {
                $this->repository->setPrimaryImage($productId, $primaryId);
            }

        } catch (Exception $e) {
            throw $e;
        }
    }
    public function uploadPhoto($productId, $file, $isPrimary = 0)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload failed");
        }

        $uploadDir = __DIR__ . '/../uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        $filename = uniqid('product_', true) . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception("File move failed");
        }

        if ($isPrimary) {

            $this->repository->updateProductMainImage(
                $productId,
                $filename
            );

            return [
                'image' => $filename,
                'type' => 'main'
            ];
        }


        return $this->repository->insertImage([
            'product_id' => $productId,
            'image' => $filename
        ]);
    }

    public function createProduct(array $input, ?array $mainImage, ?array $galleryImages): int
    {
        $productId = $this->repository->createProduct([
            'name'              => $input['name'],
            'short_description' => $input['short_description'],
            'description'       => $input['description'],
            'price'             => (float)$input['price'],
            'sale_price'        => $input['sale_price'] !== '' ? (float)$input['sale_price'] : null,
            'stock'             => (int)$input['stock'],
            'sku'               => $input['sku'],
            'brand_id'          => $input['brand_id'],
            'category_id'       => $input['category_id'],
        ]);

        if (!empty($input['tags'])) {
            $this->repository->syncTags($productId, $input['tags']);
        }

        if (!empty($input['features'])) {
            $this->repository->replaceFeatures($productId, $input['features']);
        }

        if (!empty($input['specifications'])) {
            $this->repository->replaceSpecifications($productId, $input['specifications']);
        }

        if (!empty($input['instructions'])) {
            $this->repository->replaceInstructions($productId, $input['instructions']);
        }

        if ($mainImage && $mainImage['error'] === UPLOAD_ERR_OK) {
            $filename = $this->storeUploadedFile($mainImage);
            $this->repository->updateProductMainImage($productId, $filename);
        }

        if ($galleryImages && isset($galleryImages['name']) && is_array($galleryImages['name'])) {
            $count = count($galleryImages['name']);

            for ($i = 0; $i < $count; $i++) {
                if ($galleryImages['error'][$i] !== UPLOAD_ERR_OK) continue;

                $file = [
                    'name'     => $galleryImages['name'][$i],
                    'type'     => $galleryImages['type'][$i],
                    'tmp_name' => $galleryImages['tmp_name'][$i],
                    'error'    => $galleryImages['error'][$i],
                    'size'     => $galleryImages['size'][$i],
                ];

                $filename = $this->storeUploadedFile($file);
                $this->repository->addGalleryImage($productId, $filename);
            }
        }

        return $productId;
    }

    private function storeUploadedFile(array $file): string
    {
        $uploadDir = __DIR__ . '/../../public/uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            throw new Exception('Foto opslaan mislukt');
        }

        return $filename;
    }
    private function buildProduct($rows)
    {
        if (empty($rows)) {
            return null;
        }

        $product = null;

        $seenTags = [];
        $seenFeatures = [];
        $seenSpecs = [];
        $seenInstructions = [];
        $seenImages = [];

        foreach ($rows as $row) {

            $id = $row['id'];

            /* ✅ format product */
            if (!$product) {
                $product = [
                    "id" => $id,
                    "name" => $row['name'],
                    "slug" => $row['slug'],
                    "sku" => $row['sku'],
                    "description" => $row['description'],
                    "short_description" => $row['short_description'],
                    "price" => $row['price'],
                    "sale_price" => $row['sale_price'],
                    "stock" => $row['stock'],
                    "image" => $row['image'],
                    "created_at" => $row['created_at'],

                    "category" => [
                        "name" => $row['category_name'],
                        "slug" => $row['category_slug'],
                    ],

                    "brand" => [
                        "name" => $row['brand_name'],
                        "logo" => $row['brand_logo'],
                    ],

                    "avg_rating" => $row['avg_rating'],
                    "review_count" => $row['review_count'],

                    "tags" => [],
                    "features" => [],
                    "specifications" => [],
                    "instructions" => [],
                    "images" => []
                ];
            }

            /* ✅ TAGS */
            if (!empty($row['tag_id'])) {

                $tagId = $row['tag_id'];

                if (!isset($seenTags[$tagId])) {
                    $product['tags'][] = [
                        "id" => $tagId,
                        "name" => $row['tag_name']
                    ];

                    $seenTags[$tagId] = true;
                }
            }

            /* ✅ FEATURES */
            if (!empty($row['feature_id'])) {

                $featureId = $row['feature_id'];

                if (!isset($seenFeatures[$featureId])) {
                    $product['features'][] = $row['feature'];
                    $seenFeatures[$featureId] = true;
                }
            }

            /* ✅ SPECIFICATIONS */
            if (!empty($row['specification_id'])) {

                $specId = $row['specification_id'];

                if (!isset($seenSpecs[$specId])) {
                    $product['specifications'][] = [
                        "id" => $specId,
                        "name" => $row['specification_name'],
                        "value" => $row['specification_value']
                    ];

                    $seenSpecs[$specId] = true;
                }
            }

            /* ✅ INSTRUCTIONS */
            if (!empty($row['instruction_id'])) {

                $instructionId = $row['instruction_id'];

                if (!isset($seenInstructions[$instructionId])) {
                    $product['instructions'][] = [
                        "id" => $instructionId,
                        "step" => $row['step_number'],
                        "instruction" => $row['instruction']
                    ];

                    $seenInstructions[$instructionId] = true;
                }
            }

            /* ✅ IMAGES */
            if (!empty($row['image_id'])) {

                $imageId = $row['image_id'];

                if (!isset($seenImages[$imageId])) {
                    $product['images'][] = [
                        "id" => $imageId,
                        "image" => $row['image_path'],
                        "url" => $row['image_url'],
                        "is_primary" => $row['is_primary']
                    ];

                    $seenImages[$imageId] = true;
                }
            }
        }

        return $product;
    }
}