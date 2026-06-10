<?php

namespace repositories;

use controllers\DatabaseController;

class BundlesRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new databaseController();
    }

    public function get_all_bundles()
    {

        $sql = "SELECT * FROM bundle_full_details";
        $result = $this->DB->read($sql);
        return $result;
    }

    public function find_bundle($bundle_id){

        $sql = "SELECT * FROM bundle_full_details WHERE id = :bundle_id";
        $result = $this->DB->read($sql, ['bundle_id' => $bundle_id]);
        return $result;
    }
    public function get_top_bundles(int $limit = 3)
    {
        $sql = "
        SELECT id
        FROM bundle_full_details
        GROUP BY id
        HAVING AVG(product_avg_rating) IS NOT NULL
        ORDER BY AVG(product_avg_rating) DESC
        LIMIT " . (int)$limit . "
    ";
        $topIds = $this->DB->read($sql);

        if (empty($topIds)) return [];

        $results = [];
        foreach ($topIds as $row) {
            $rows = $this->DB->read(
                "SELECT * FROM bundle_full_details WHERE id = :id",
                ['id' => $row['id']]
            );
            if ($rows) $results[] = $rows;
        }
        return $results;
    }
}