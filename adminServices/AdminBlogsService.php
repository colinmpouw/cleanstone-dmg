<?php

namespace adminServices;

use adminRepositories\AdminBlogsRepository;

class AdminBlogsService
{
    private AdminBlogsRepository $blogRepository;

    public function __construct()
    {
        $this->blogRepository = new AdminBlogsRepository();
    }

    public function getAllBlogs(): array
    {
        return $this->blogRepository->getAllBlogs();
    }

    public function getBlogThemes(): array
    {
        $tags = $this->blogRepository->getBlogTags();

        return array_column($tags, 'name');
    }

    public function getBlogForEdit(int $id): ?array
    {
        $blog = $this->blogRepository->getBlogById($id);

        if (!$blog) {
            return null;
        }

        $blog['tags'] = !empty($blog['tag_keys'])
            ? explode('|', $blog['tag_keys'])
            : array_filter(array_map('trim', explode(',', $blog['tag'] ?? '')));

        return $blog;
    }

    public function createBlog(array $input): array
    {
        $data = $this->normalizeBlogInput($input);

        $errors = $this->validateBlog($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }

        $saved = $this->blogRepository->createBlog($data);

        return [
            'success' => $saved,
            'errors' => $saved ? [] : ['Blog kon niet worden opgeslagen.'],
            'data' => $data,
        ];
    }

    public function updateBlog(int $id, array $input): array
    {
        $data = $this->normalizeBlogInput($input);
        $data['blog_id'] = $id;

        $errors = $this->validateBlog($data);
        if ($id <= 0) {
            $errors[] = 'Blog niet gevonden.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }

        $saved = $this->blogRepository->updateBlog($id, $data);

        return [
            'success' => $saved,
            'errors' => $saved ? [] : ['Blog kon niet worden bijgewerkt.'],
            'data' => $data,
        ];
    }

    public function deleteBlog(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        return $this->blogRepository->deleteBlog($id);
    }

    private function normalizeBlogInput(array $input): array
    {
        $tags = $input['tags'] ?? [];
        if (!is_array($tags)) {
            $tags = [$tags];
        }

        $tags = array_values(array_unique(array_filter(array_map('trim', $tags))));

        $data = [
            'title' => trim($input['title'] ?? ''),
            'article' => trim($input['article'] ?? ''),
            'arthor' => trim($input['arthor'] ?? ''),
            'tags' => $tags,
            'date' => trim($input['date'] ?? ''),
            'image' => trim($input['image'] ?? ''),
            'excerpt' => trim($input['excerpt'] ?? ''),
        ];

        if ($data['date'] === '') {
            $data['date'] = date('Y-m-d H:i:s');
        }

        return $data;
    }

    private function validateBlog(array $data): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Titel is verplicht.';
        }

        if ($data['article'] === '') {
            $errors[] = 'Artikeltekst is verplicht.';
        }

        if ($data['arthor'] === '') {
            $errors[] = 'Auteur is verplicht.';
        }

        $themes = $this->getBlogThemes();

        if (empty($data['tags'])) {
            $errors[] = 'Kies minimaal een thema.';
        }

        foreach ($data['tags'] as $tag) {
            if (!in_array($tag, $themes, true)) {
                $errors[] = 'Kies alleen geldige thema\'s.';
                break;
            }
        }

        if ($data['date'] !== '' && strtotime($data['date']) === false) {
            $errors[] = 'Datum heeft geen geldig formaat.';
        }

        return $errors;
    }
}
