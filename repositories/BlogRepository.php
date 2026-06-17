<?php

namespace repositories;

use controllers\DatabaseController;

class BlogRepository
{
    private DatabaseController $db;

    public function __construct()
    {
        $this->db = new DatabaseController();
    }

    public function getAllPosts(): array
    {
        return $this->db->read('SELECT blog_id, title, article, arthor, tag, image, excerpt, date FROM blog ORDER BY date DESC');
    }

    public function createPost(array $data): bool
    {
        return $this->db->save(
            'INSERT INTO blog (title, article, arthor, tag, date) VALUES (:title, :article, :arthor, :tag, NOW())',
            [
                'title' => $data['title'],
                'article' => $data['article'],
                'arthor' => $data['arthor'],
                'tag' => $data['tag'],
            ]
        );
    }

    public function getPostById(int $id): ?array
    {
        $rows = $this->db->read(
            'SELECT blog_id, title, article, arthor, tag, image, excerpt, date FROM blog WHERE blog_id = :id LIMIT 1',
            ['id' => $id]
        );

        return $rows[0] ?? null;
    }

    public function getRelatedPosts(string $tag, int $excludeId, int $limit = 3): array
    {
        return $this->db->read(
            'SELECT blog_id, title, article, arthor, tag, image, excerpt, date
             FROM blog
             WHERE tag = :tag AND blog_id != :exclude_id
             ORDER BY date DESC
             LIMIT ' . (int) $limit,
            [
                'tag' => $tag,
                'exclude_id' => $excludeId,
            ]
        );
    }
}