<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminBundlesRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
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
}