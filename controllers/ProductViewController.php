<?php

namespace controllers;

use repositories\ProductViewRepository;

class ProductViewController
{
    private ProductViewRepository $repository;

    public function __construct(\Router $router)
    {
        $this->repository = new ProductViewRepository();

        $router->get('/product/{slug}', [$this, 'viewProduct']);
        $router->get('/api/product/{slug}', [$this, 'getProductData']);
        $router->get('/api/product/{id}/related', [$this, 'getRelatedProducts']);
    }

    public function viewProduct(string $slug)
    {
        $product = $this->repository->getProductBySlug($slug);

        if (!$product) {
            http_response_code(404);
            require __DIR__ . '/../public/404.php';
            exit;
        }

        $rating = $this->repository->getAverageRating($product['id']);
        $specifications = $this->repository->getProductSpecifications($product['id']);
        $features = $this->repository->getProductFeatures($product['id']);
        $instructions = $this->repository->getProductInstructions($product['id']);
        $images = $this->repository->getProductImages($product['id']);
        $reviews = $this->repository->getProductReviews($product['id'], 5, 0);

        require __DIR__ . '/../public/product.php';
    }

    public function getProductData(string $slug)
    {
        $product = $this->repository->getProductBySlug($slug);

        if (!$product) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Product not found']);
            exit;
        }

        $rating = $this->repository->getAverageRating($product['id']);
        $specifications = $this->repository->getProductSpecifications($product['id']);
        $features = $this->repository->getProductFeatures($product['id']);
        $instructions = $this->repository->getProductInstructions($product['id']);
        $images = $this->repository->getProductImages($product['id']);

        header('Content-Type: application/json');
        echo json_encode([
            'product' => $product,
            'rating' => $rating,
            'specifications' => $specifications,
            'features' => $features,
            'instructions' => $instructions,
            'images' => $images
        ]);
    }

    public function getRelatedProducts(int $id)
    {
        $product = $this->repository->getProductById($id);

        if (!$product) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Product not found']);
            exit;
        }

        $related = $this->repository->getRelatedProducts($product['category_id'], $id, 4);

        header('Content-Type: application/json');
        echo json_encode(['related_products' => $related]);
    }
}
