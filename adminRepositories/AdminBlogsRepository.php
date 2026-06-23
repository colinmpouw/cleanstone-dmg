<?php

namespace adminRepositories;

use controllers\DatabaseController;

class AdminBlogsRepository
{
    private DatabaseController $db;

    public function __construct()
    {
        $this->db = new DatabaseController();
    }

    public function getAllBlogs(): array
    {
        return $this->db->read(
            'SELECT blog_id, title, article, arthor, tag, date, image, excerpt
             FROM blog
             ORDER BY date DESC, blog_id DESC'
        );
    }

    public function createBlog(array $data): bool
    {
        $nextIdRows = $this->db->read('SELECT COALESCE(MAX(blog_id), 0) + 1 AS next_id FROM blog');
        $nextId = (int) ($nextIdRows[0]['next_id'] ?? 1);

        return $this->db->save(
            'INSERT INTO blog (blog_id, title, article, arthor, tag, date, image, excerpt)
             VALUES (:blog_id, :title, :article, :arthor, :tag, :date, :image, :excerpt)',
            [
                'blog_id' => $nextId,
                'title' => $data['title'],
                'article' => $data['article'],
                'arthor' => $data['arthor'],
                'tag' => $data['tag'],
                'date' => $data['date'],
                'image' => $data['image'] ?: null,
                'excerpt' => $data['excerpt'] ?: null,
            ]
        );
    }
}
