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

    public function get_all_bundels()
    {

        $sql = "SELECT * FROM bundle_full_details";
        $result = $this->DB->read($sql);
        return $result;
    }

}