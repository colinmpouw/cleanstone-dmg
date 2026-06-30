<?php

namespace adminControllers;

class adminCategoryController
{

    public function __construct($router)
    {

        $router->get('/admin/categories-tags', [$this, 'ShowCategories']);
    }

    public function ShowCategories()
    {
        require __DIR__ . '/../admin/adminCategories-Tags.php';
    }
}