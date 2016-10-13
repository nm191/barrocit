<?php

/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 12-10-2016
 * Time: 10:53
 */
class Customer
{

    private $db;

    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();

    }

    public function getAlldata()
    {
        $sql = "SELECT * FROM tbl_customers";
        $result = $this->db->pdo->query($sql);
        return $result;
    }

    public function delete()
    {
        

    }
}