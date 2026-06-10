<?php

namespace controllers;

use repositories\BlogRepository;

require_once __DIR__ . '/../repositories/BlogRepository.php';

class BlogController
{
    private BlogRepository $blogRepository;

    public function __construct($router)
    {
        $this->blogRepository = new BlogRepository();

        $router->get('/blog', [$this, 'pageBlog']);
        $router->get('/blog/{id}', [$this, 'pageBlogDetail']);
    }

    public function pageBlog(): void
    {
        $blogs = $this->blogRepository->getAllPosts();
        if (empty($blogs)) {
            $blogs = [$this->fallbackBlogPost()];
        }
        require __DIR__ . '/../public/blog.php';
    }

    public function pageBlogDetail(string $id): void
    {
        $blogId = (int) $id;
        $blog = $this->blogRepository->getPostById($blogId);

        if (!$blog) {
            $blog = $this->fallbackBlogPost();
            $blog['blog_id'] = $blogId > 0 ? $blogId : 1;
        }

        $relatedBlogs = $this->blogRepository->getRelatedPosts($blog['tag'], $blogId);

        if (empty($relatedBlogs)) {
            $relatedBlogs = [$this->fallbackBlogPost()];
        }

        require __DIR__ . '/../public/blog-detail.php';
    }

    private function fallbackBlogPost(): array
    {
        return [
            'blog_id' => 1,
            'title' => 'Natuursteen onderhoud in de keuken',
            'article' => "Natuursteen in de keuken blijft het mooist wanneer je werkt met de juiste dagelijkse routine.\n\nBegin altijd met een zachte doek, warm water en een pH-neutraal reinigingsmiddel. Vermijd agressieve schoonmaakmiddelen, schuurmiddelen en producten met zuur, omdat die de toplaag kunnen aantasten.\n\nVoor een aanrechtblad is het slim om gemorste vloeistoffen direct weg te nemen. Zeker olie, citroensap, wijn en koffie kunnen vlekken veroorzaken wanneer ze te lang blijven liggen. Gebruik daarom een mild onderhoudsproduct en bescherm het oppervlak indien nodig met een impregneermiddel.\n\nIn deze gids lees je hoe je natuursteen langer mooi houdt, waar je op moet letten bij vlekken en welke producten passen bij dagelijks onderhoud.",
            'arthor' => 'CleanStone Team',
            'tag' => 'onderhoudstips',
            'image' => '/public/assets/schone_tegel.png',
            'excerpt' => 'Praktische tips om natuursteen in de keuken dagelijks mooi en schoon te houden.',
            'date' => '2026-06-06 17:44:23',
        ];
    }
}