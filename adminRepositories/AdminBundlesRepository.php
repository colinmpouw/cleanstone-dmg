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

    public function find_bundle($bundle_id)
    {

        $sql = "SELECT * FROM bundle_full_details WHERE id = :bundle_id";
        $result = $this->DB->read($sql, ['bundle_id' => $bundle_id]);
        return $result;
    }

    public function updatePhoto($bundle_id, $fileName)
    {
        $sql = "UPDATE bundles SET image = :fileName WHERE id = :bundle_id";
        $result = $this->DB->read($sql, ['bundle_id' => $bundle_id, 'fileName' => $fileName]);
        return $result;
    }

    public function updateBundle($id, $name, $description, $price, $tag)
    {
        $sql = "UPDATE bundles 
            SET name = ?, description = ?, price = ?, bundle_tag = ?
            WHERE id = ?";
        $result = $this->DB->save($sql, [$name, $description, $price, $tag, $id]);
        return $result;

    }

    public function deleteBundleProducts($bundle_id)
    {
        $sql = "DELETE FROM bundle_products WHERE bundle_id = ?";
        $result = $this->DB->save($sql, [$bundle_id]);
        return $result;
    }

    public function addBundleProduct($data)
    {
        $sql = "INSERT INTO bundle_products 
            (bundle_id, product_id, quantity)
            VALUES (?, ?, ?)";

        $result = $this->DB->read($sql, [$data['bundle_id'], $data['product_id'], $data['quantity']]);
        return $result;
    }


}