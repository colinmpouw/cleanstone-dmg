<?php

namespace repositories;

use controllers\DatabaseController;

class BundelsRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new databaseController();
    }

    public function get_all_bundels()
    {

        $sql = "SELECT * FROM product_bundles";
        $result = $this->DB->read($sql);
        return $result;
    }

}