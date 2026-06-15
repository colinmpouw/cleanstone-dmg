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
        $router->post('/product/{slug}/review', [$this, 'submitReview']);
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

        if (!$rating) {
            $rating = ['average_rating' => 0, 'review_count' => 0];
        } else {
            $rating['average_rating'] = $rating['average_rating'] !== null ? round((float)$rating['average_rating'], 1) : 0;
            $rating['review_count'] = (int)($rating['review_count'] ?? 0);
        }

        $reviewErrors = $_SESSION['review_errors'] ?? [];
        $reviewOld = $_SESSION['review_old'] ?? ['rating' => '', 'review' => ''];
        $reviewSuccess = $_SESSION['review_success'] ?? '';
        unset($_SESSION['review_errors'], $_SESSION['review_old'], $_SESSION['review_success']);

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
        $reviews = $this->repository->getProductReviews($product['id'], 5, 0);

        if (!$rating) {
            $rating = ['average_rating' => 0, 'review_count' => 0];
        } else {
            $rating['average_rating'] = $rating['average_rating'] !== null ? round((float)$rating['average_rating'], 1) : 0;
            $rating['review_count'] = (int)($rating['review_count'] ?? 0);
        }

        header('Content-Type: application/json');
        echo json_encode([
            'product' => $product,
            'rating' => $rating,
            'specifications' => $specifications,
            'features' => $features,
            'instructions' => $instructions,
            'images' => $images,
            'reviews' => $reviews
        ]);
    }

    public function submitReview(string $slug)
    {
        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $product = $this->repository->getProductBySlug($slug);
        if (!$product) {
            http_response_code(404);
            require __DIR__ . '/../public/404.php';
            exit;
        }

        $errors = [];
        $rating = (int)($_POST['rating'] ?? 0);
        $reviewText = trim($_POST['review'] ?? '');

        if ($rating < 1 || $rating > 5) {
            $errors[] = 'Kies een beoordeling tussen 1 en 5 sterren.';
        }
        if ($reviewText === '') {
            $errors[] = 'Vul uw review in.';
        }

        if (!empty($errors)) {
            $_SESSION['review_errors'] = $errors;
            $_SESSION['review_old'] = ['rating' => $rating, 'review' => $reviewText];
            header('Location: /product/' . urlencode($product['slug']));
            exit;
        }

        $this->repository->createProductReview([
            'user_id' => $_SESSION['user']['id'],
            'product_id' => $product['id'],
            'rating' => $rating,
            'review' => $reviewText,
        ]);

        $_SESSION['review_success'] = 'Thanks! Uw review is geplaatst.';
        header('Location: /product/' . urlencode($product['slug']));
        exit;
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
