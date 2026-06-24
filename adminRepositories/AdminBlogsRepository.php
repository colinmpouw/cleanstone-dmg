<?php

namespace adminRepositories;

use controllers\DatabaseController;

class AdminBlogsRepository
{
    private DatabaseController $db;

    public function __construct()
    {
        $this->db = new DatabaseController();
        $this->ensureBlogTagTables();
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

    private function ensureBlogTagTables(): void
    {
        $this->db->save(
            "CREATE TABLE IF NOT EXISTS blogtags (
                id int(11) NOT NULL AUTO_INCREMENT,
                name varchar(45) NOT NULL,
                display_order int(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (id),
                UNIQUE KEY name (name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );

        $this->db->save(
            "CREATE TABLE IF NOT EXISTS blog_blogtags (
                blog_id int(11) NOT NULL,
                blogtag_id int(11) NOT NULL,
                PRIMARY KEY (blog_id, blogtag_id),
                KEY blogtag_id (blogtag_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );

        $this->db->save(
            "INSERT INTO blogtags (id, name, display_order) VALUES
                (1, 'Algemeen', 1),
                (2, 'Buitenplaatsen', 2),
                (3, 'Composiet', 3),
                (4, 'Graniet', 4),
                (5, 'Hardsteen', 5),
                (6, 'Marmer', 6),
                (7, 'Onze Merken', 7)
             ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                display_order = VALUES(display_order)"
        );

        $this->db->save(
            "INSERT IGNORE INTO blog_blogtags (blog_id, blogtag_id)
             SELECT b.blog_id, bt.id
             FROM blog b
             JOIN blogtags bt ON b.tag = bt.name"
        );
    }
}
