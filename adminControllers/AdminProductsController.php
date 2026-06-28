<?php

namespace adminControllers;

use adminServices\AdminProductsService;

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
        $products = $this->service->getAllProducts();
        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    public function get_all_tags()
    {
        $products = $this->service->getTags();
        header('Content-Type: application/json');
        echo json_encode($products);
    }
    public function get_all_brands()
    {
        $products = $this->service->getBrands();
        header('Content-Type: application/json');
        echo json_encode($products);
    }
    public function get_all_categories()
    {
        $products = $this->service->getCategories();
        header('Content-Type: application/json');
        echo json_encode($products);
    }
    public function findProductById($id){
        $products = $this->service->getProductById($id);
        echo json_encode($products);
    }

}