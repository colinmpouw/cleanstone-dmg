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

        if (empty($specifications)) {
            $specifications = [
                ['name' => 'Inhoud', 'value' => '1 liter'],
                ['name' => 'pH', 'value' => '7-8 (neutraal)'],
                ['name' => 'Verdunning', 'value' => '1:100'],
                ['name' => 'Toepassing', 'value' => 'Alle natuursteensoorten'],
            ];
        }

        if (empty($features)) {
            $features = [
                ['feature' => 'pH-neutraal en veilig voor natuursteen'],
                ['feature' => 'Geconcentreerd: 1 liter = 100 liter schoonmaakwater'],
                ['feature' => 'Geschikt voor alle steensoorten'],
                ['feature' => 'Laat geen strepen of vlekken achter'],
                ['feature' => 'Milieuvriendelijk en biologisch afbreekbaar'],
            ];
        }

        if (empty($instructions)) {
            $instructions = [
                ['step_number' => 1, 'instruction' => 'Verdun 10ml reiniger in 1 liter water'],
                ['step_number' => 2, 'instruction' => 'Breng aan met een vochtige doek of mop'],
                ['step_number' => 3, 'instruction' => 'Laat kort inwerken en droge met een schone doek'],
                ['step_number' => 4, 'instruction' => 'Voor hardnekkige vlekken langer laten inwerken'],
            ];
        }

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

        if (empty($specifications)) {
            $specifications = [
                ['name' => 'Inhoud', 'value' => '1 liter'],
                ['name' => 'pH', 'value' => '7-8 (neutraal)'],
                ['name' => 'Verdunning', 'value' => '1:100'],
                ['name' => 'Toepassing', 'value' => 'Alle natuursteensoorten'],
            ];
        }

        if (empty($features)) {
            $features = [
                ['feature' => 'pH-neutraal en veilig voor natuursteen'],
                ['feature' => 'Geconcentreerd: 1 liter = 100 liter schoonmaakwater'],
                ['feature' => 'Geschikt voor alle steensoorten'],
                ['feature' => 'Laat geen strepen of vlekken achter'],
                ['feature' => 'Milieuvriendelijk en biologisch afbreekbaar'],
            ];
        }

        if (empty($instructions)) {
            $instructions = [
                ['step_number' => 1, 'instruction' => 'Verdun 10ml reiniger in 1 liter water'],
                ['step_number' => 2, 'instruction' => 'Breng aan met een vochtige doek of mop'],
                ['step_number' => 3, 'instruction' => 'Laat kort inwerken en droge met een schone doek'],
                ['step_number' => 4, 'instruction' => 'Voor hardnekkige vlekken langer laten inwerken'],
            ];
        }

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
