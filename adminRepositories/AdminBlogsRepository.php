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
            "SELECT b.blog_id,
                    b.title,
                    b.article,
                    b.arthor,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR ', '), b.tag) AS tag,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR '|'), b.tag) AS tag_keys,
                    b.date,
                    b.image,
                    b.excerpt
             FROM blog b
             LEFT JOIN blog_blogtags bbt ON b.blog_id = bbt.blog_id
             LEFT JOIN blogtags bt ON bbt.blogtag_id = bt.id
             GROUP BY b.blog_id, b.title, b.article, b.arthor, b.tag, b.date, b.image, b.excerpt
             ORDER BY b.date DESC, b.blog_id DESC"
        );
    }

    public function getBlogTags(): array
    {
        return $this->db->read('SELECT name FROM blogtags ORDER BY display_order ASC, name ASC');
    }

    public function getBlogById(int $id): ?array
    {
        $rows = $this->db->read(
            "SELECT b.blog_id,
                    b.title,
                    b.article,
                    b.arthor,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR ', '), b.tag) AS tag,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR '|'), b.tag) AS tag_keys,
                    b.date,
                    b.image,
                    b.excerpt
             FROM blog b
             LEFT JOIN blog_blogtags bbt ON b.blog_id = bbt.blog_id
             LEFT JOIN blogtags bt ON bbt.blogtag_id = bt.id
             WHERE b.blog_id = :id
             GROUP BY b.blog_id, b.title, b.article, b.arthor, b.tag, b.date, b.image, b.excerpt
             LIMIT 1",
            ['id' => $id]
        );

        return $rows[0] ?? null;
    }

    public function createBlog(array $data): bool
    {
        $nextIdRows = $this->db->read('SELECT COALESCE(MAX(blog_id), 0) + 1 AS next_id FROM blog');
        $nextId = (int) ($nextIdRows[0]['next_id'] ?? 1);

        $saved = $this->db->save(
            'INSERT INTO blog (blog_id, title, article, arthor, tag, date, image, excerpt)
             VALUES (:blog_id, :title, :article, :arthor, :tag, :date, :image, :excerpt)',
            [
                'blog_id' => $nextId,
                'title' => $data['title'],
                'article' => $data['article'],
                'arthor' => $data['arthor'],
                'tag' => implode(', ', $data['tags']),
                'date' => $data['date'],
                'image' => $data['image'] ?: null,
                'excerpt' => $data['excerpt'] ?: null,
            ]
        );

        if (!$saved) {
            return false;
        }

        return $this->saveBlogTags($nextId, $data['tags']);
    }

    public function updateBlog(int $id, array $data): bool
    {
        $saved = $this->db->save(
            'UPDATE blog
             SET title = :title,
                 article = :article,
                 arthor = :arthor,
                 tag = :tag,
                 date = :date,
                 image = :image,
                 excerpt = :excerpt
             WHERE blog_id = :blog_id',
            [
                'blog_id' => $id,
                'title' => $data['title'],
                'article' => $data['article'],
                'arthor' => $data['arthor'],
                'tag' => implode(', ', $data['tags']),
                'date' => $data['date'],
                'image' => $data['image'] ?: null,
                'excerpt' => $data['excerpt'] ?: null,
            ]
        );

        if (!$saved) {
            return false;
        }

        return $this->saveBlogTags($id, $data['tags']);
    }

    public function deleteBlog(int $id): bool
    {
        $this->db->save('DELETE FROM blog_blogtags WHERE blog_id = :blog_id', ['blog_id' => $id]);

        return $this->db->save('DELETE FROM blog WHERE blog_id = :blog_id', ['blog_id' => $id]);
    }

    private function saveBlogTags(int $blogId, array $tagNames): bool
    {
        $this->db->save('DELETE FROM blog_blogtags WHERE blog_id = :blog_id', ['blog_id' => $blogId]);

        foreach ($tagNames as $tagName) {
            $rows = $this->db->read('SELECT id FROM blogtags WHERE name = :name LIMIT 1', ['name' => $tagName]);
            $tagId = (int) ($rows[0]['id'] ?? 0);

            if ($tagId === 0) {
                return false;
            }

            $saved = $this->db->save(
                'INSERT INTO blog_blogtags (blog_id, blogtag_id) VALUES (:blog_id, :blogtag_id)',
                [
                    'blog_id' => $blogId,
                    'blogtag_id' => $tagId,
                ]
            );

            if (!$saved) {
                return false;
            }
        }

        return true;
    }
}
