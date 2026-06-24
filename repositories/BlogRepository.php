<?php

namespace repositories;

use controllers\DatabaseController;

class BlogRepository
{
    private DatabaseController $db;

    public function __construct()
    {
        $this->db = new DatabaseController();
        $this->ensureBlogTagTables();
    }

    public function getAllPosts(): array
    {
        return $this->db->read(
            "SELECT b.blog_id,
                    b.title,
                    b.article,
                    b.arthor,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR ', '), b.tag) AS tag,
                    COALESCE(GROUP_CONCAT(bt.name ORDER BY bt.display_order ASC SEPARATOR '|'), b.tag) AS tag_keys,
                    b.image,
                    b.excerpt,
                    b.date
             FROM blog b
             LEFT JOIN blog_blogtags bbt ON b.blog_id = bbt.blog_id
             LEFT JOIN blogtags bt ON bbt.blogtag_id = bt.id
             GROUP BY b.blog_id, b.title, b.article, b.arthor, b.tag, b.image, b.excerpt, b.date
             ORDER BY b.date DESC"
        );
    }

    public function getBlogTags(): array
    {
        return $this->db->read('SELECT name FROM blogtags ORDER BY display_order ASC, name ASC');
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
