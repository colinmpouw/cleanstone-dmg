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

    public function createBlog(array $input): array
    {
        $data = [
            'title' => trim($input['title'] ?? ''),
            'article' => trim($input['article'] ?? ''),
            'arthor' => trim($input['arthor'] ?? ''),
            'tag' => trim($input['tag'] ?? ''),
            'date' => trim($input['date'] ?? ''),
            'image' => trim($input['image'] ?? ''),
            'excerpt' => trim($input['excerpt'] ?? ''),
        ];

        if ($data['date'] === '') {
            $data['date'] = date('Y-m-d H:i:s');
        }

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

        if ($data['tag'] === '') {
            $errors[] = 'Tag is verplicht.';
        }

        if ($data['date'] !== '' && strtotime($data['date']) === false) {
            $errors[] = 'Datum heeft geen geldig formaat.';
        }

        return $errors;
    }
}
