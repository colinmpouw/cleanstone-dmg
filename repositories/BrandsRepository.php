<?php

namespace repositories;
use controllers\DatabaseController;

class BrandsRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function get_all_brands()
    {
        $sql = "SELECT id, name, logo , discription FROM brands";
        return $this->DB->read($sql);
    }
}