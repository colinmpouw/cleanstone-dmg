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
        $router->post('/admin/blog/toevoegen', [$this, 'handleBlogPost']);
        $router->post('/admin/adminblog.php', [$this, 'handleBlogPost']);
    }

    public function blogPage(): void
    {
        $blogs = $this->blogService->getAllBlogs();
        $blogThemes = $this->blogService->getBlogThemes();
        $errors = (($_GET['error'] ?? '') === 'delete') ? ['Blog kon niet worden verwijderd.'] : [];
        $editBlogId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
        $old = $editBlogId > 0 ? ($this->blogService->getBlogForEdit($editBlogId) ?? []) : [];
        $successMessage = $this->successMessageFromQuery();

        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }

    public function handleBlogPost(): void
    {
        $action = $_POST['blog_action'] ?? 'create';

        if ($action === 'delete') {
            $deleted = $this->blogService->deleteBlog((int) ($_POST['blog_id'] ?? 0));
            header('Location: /admin/adminblog.php?' . ($deleted ? 'deleted=1' : 'error=delete'));
            die();
        }

        if ($action === 'update') {
            $this->updateBlog();
            return;
        }

        $this->addBlog();
    }

    private function addBlog(): void
    {
        $result = $this->blogService->createBlog($_POST, $_FILES);

        if ($result['success']) {
            header('Location: /admin/adminblog.php?created=1');
            die();
        }

        $blogs = $this->blogService->getAllBlogs();
        $blogThemes = $this->blogService->getBlogThemes();
        $errors = $result['errors'];
        $old = $result['data'];
        $editBlogId = 0;
        $successMessage = '';

        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }

    private function updateBlog(): void
    {
        $blogId = (int) ($_POST['blog_id'] ?? 0);
        $result = $this->blogService->updateBlog($blogId, $_POST, $_FILES);

        if ($result['success']) {
            header('Location: /admin/adminblog.php?updated=1');
            die();
        }

        $blogs = $this->blogService->getAllBlogs();
        $blogThemes = $this->blogService->getBlogThemes();
        $errors = $result['errors'];
        $old = $result['data'];
        $editBlogId = $blogId;
        $successMessage = '';

        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }

    private function successMessageFromQuery(): string
    {
        if (isset($_GET['created'])) {
            return 'Blog is toegevoegd.';
        }

        if (isset($_GET['updated'])) {
            return 'Blog is bijgewerkt.';
        }

        if (isset($_GET['deleted'])) {
            return 'Blog is verwijderd.';
        }

        if (($_GET['error'] ?? '') === 'delete') {
            return '';
        }

        return '';
    }
}
