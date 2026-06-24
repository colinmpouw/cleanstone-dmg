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

    public function createBlog(array $input, array $files = []): array
    {
        $data = $this->normalizeBlogInput($input);

        $errors = $this->validateBlog($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }

        $imageUpload = $this->handleImageUpload($files['image'] ?? null, $data['image']);
        if ($imageUpload['error'] !== null) {
            return ['success' => false, 'errors' => [$imageUpload['error']], 'data' => $data];
        }

        $data['image'] = $imageUpload['path'];

        $saved = $this->blogRepository->createBlog($data);

        return [
            'success' => $saved,
            'errors' => $saved ? [] : ['Blog kon niet worden opgeslagen.'],
            'data' => $data,
        ];
    }

    public function updateBlog(int $id, array $input, array $files = []): array
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

        $imageUpload = $this->handleImageUpload($files['image'] ?? null, $data['image']);
        if ($imageUpload['error'] !== null) {
            return ['success' => false, 'errors' => [$imageUpload['error']], 'data' => $data];
        }

        $data['image'] = $imageUpload['path'];

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
            'image' => trim($input['current_image'] ?? $input['image'] ?? ''),
            'excerpt' => trim($input['excerpt'] ?? ''),
        ];

        if ($data['date'] === '') {
            $data['date'] = date('Y-m-d H:i:s');
        }

        return $data;
    }

    private function handleImageUpload(?array $file, string $currentPath = ''): array
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['path' => $currentPath, 'error' => null];
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return ['path' => $currentPath, 'error' => 'Afbeelding uploaden is mislukt.'];
        }

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $extension = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            return ['path' => $currentPath, 'error' => 'Gebruik een afbeelding van het type png, jpg, jpeg, webp of gif.'];
        }

        if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
            return ['path' => $currentPath, 'error' => 'De afbeelding mag maximaal 5 MB zijn.'];
        }

        $tmpName = $file['tmp_name'] ?? '';
        if ($tmpName === '' || !is_uploaded_file($tmpName)) {
            return ['path' => $currentPath, 'error' => 'Afbeelding uploaden is mislukt.'];
        }

        $uploadDir = __DIR__ . '/../uploads/blog';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            return ['path' => $currentPath, 'error' => 'Uploadmap kon niet worden aangemaakt.'];
        }

        $filename = 'blog_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $targetPath = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($tmpName, $targetPath)) {
            return ['path' => $currentPath, 'error' => 'Afbeelding kon niet worden opgeslagen.'];
        }

        return ['path' => '/uploads/blog/' . $filename, 'error' => null];
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
