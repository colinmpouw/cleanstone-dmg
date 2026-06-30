<?php

namespace adminControllers;

use adminServices\AdminProductsService;
use Exception;

class AdminProductsController
{
    private $service;
    public function __construct($router)
    {
        $this->service = new AdminProductsService();

        $router->get('/admin/producten', [$this, 'productsPage']);
        $router->get('/admin/producten/{id}/edit', [$this, 'productsEditPage']);
        $router->get('/admin/producten/add', [$this, 'productsAddPage']);


        $router->get('/api/admin/get_all_products', [$this, 'get_all_products']);
        $router->get('/api/admin/get_product/{id}', [$this, 'findProductById']);
        $router->get('/api/admin/get_all_brands', [$this, 'get_all_brands']);
        $router->get('/api/admin/get_all_tags', [$this, 'get_all_tags']);
        $router->get('/api/admin/get_all_categories', [$this, 'get_all_categories']);
        $router->delete('/api/admin/delete_product/{id}', [$this, 'deleteProduct']);


        $router->put('/api/admin/update_product/{productId}', [$this, 'updateProduct']);
        $router->post('/api/admin/upload_product_photo/{productId}', [$this, 'updateProductPhoto']);
        $router->post('/api/admin/create_product', [$this, 'createProduct']);


    }
    public function productsPage(){
        require_once __DIR__ . '/../admin/adminProducts.php';
        die();
    }
    public function productsEditPage($id){
        echo '<script>window.productId = ' . json_encode((int)$id) . ';
console.log(window.productId);
</script>';
        require_once __DIR__ . '/../admin/adminEditProduct.php';
    }
    public function productsAddPage(){

        require_once __DIR__ . '/../admin/adminAddProduct.php';
    }
    public function get_all_products()
    {
        header('Content-Type: application/json');
        $products = $this->service->getAllProducts();


        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function get_all_tags()
    {
        header('Content-Type: application/json');
        $products = $this->service->getTags();

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function get_all_brands()
    {
        header('Content-Type: application/json');
        $products = $this->service->getBrands();

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function get_all_categories()
    {   header('Content-Type: application/json');
        $products = $this->service->getCategories();

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function findProductById($id){
        $products = $this->service->getProductById($id);
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function deleteProduct($id){
        header('Content-Type: application/json');
        $products = $this->service->deleteProduct($id);


        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function updateProduct($id)
    {
        $input = json_decode(file_get_contents("php://input"), true);

        try {
            $this->service->updateProduct($id, $input);

            echo json_encode([
                "success" => true
            ]);
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function updateProductPhoto($productId)
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['photo'])) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "No file uploaded"
            ]);
            return;
        }

        try {
            $result = $this->service->uploadPhoto(
                $productId,
                $_FILES['photo'],
                $_POST['is_primary'] ?? 0
            );

            echo json_encode([
                "success" => true,
                "message" => "Photo uploaded successfully",
                "data" => $result
            ]);

        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function createProduct()
    {
        header('Content-Type: application/json');

        try {
            $input = [
                'name'              => $_POST['name'] ?? '',
                'short_description' => $_POST['short_description'] ?? '',
                'description'       => $_POST['description'] ?? '',
                'price'             => $_POST['price'] ?? 0,
                'sale_price'        => $_POST['sale_price'] ?? '',
                'stock'             => $_POST['stock'] ?? 0,
                'sku'               => $_POST['sku'] ?? '',
                'brand_id'          => $_POST['brand_id'] ?: null,
                'category_id'       => $_POST['category_id'] ?: null,
                'tags'              => json_decode($_POST['tags'] ?? '[]', true),
                'features'          => json_decode($_POST['features'] ?? '[]', true),
                'specifications'    => json_decode($_POST['specifications'] ?? '[]', true),
                'instructions'      => json_decode($_POST['instructions'] ?? '[]', true),
            ];

            $mainImage     = $_FILES['main_image'] ?? null;
            $galleryImages = $_FILES['gallery_images'] ?? null;

            $productId = $this->service->createProduct($input, $mainImage, $galleryImages);

            echo json_encode([
                "success" => true,
                "data" => ["id" => $productId]
            ]);

        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}