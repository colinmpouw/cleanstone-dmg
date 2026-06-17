<?php

namespace adminControllers;

use adminServices\AdminBlogsService;

class AdminBlogsController
{
    private AdminBlogsService $blogService;

    public function __construct($router)
    {
        $this->blogService = new AdminBlogsService();

        $router->get('/admin/blog', [$this, 'blogPage']);
        $router->get('/admin/adminblog.php', [$this, 'blogPage']);
        $router->post('/admin/blog/toevoegen', [$this, 'addBlog']);
        $router->post('/admin/adminblog.php', [$this, 'addBlog']);
    }

    public function blogPage(): void
    {
        $blogs = $this->blogService->getAllBlogs();
        $errors = [];
        $old = [];
        $successMessage = isset($_GET['created']) ? 'Blog is toegevoegd.' : '';

        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }

    public function addBlog(): void
    {
        $result = $this->blogService->createBlog($_POST);

        if ($result['success']) {
            header('Location: /admin/blog?created=1');
            die();
        }

        $blogs = $this->blogService->getAllBlogs();
        $errors = $result['errors'];
        $old = $result['data'];
        $successMessage = '';

        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }
}
