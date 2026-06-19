<?php

namespace repositories;
use controllers\DatabaseController;

class OrderRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }


}