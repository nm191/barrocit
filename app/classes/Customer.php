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

    public function delete($customer_id)
    {
        $sql = "DELETE FROM `tbl_customers` WHERE customer_id = :customer_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $result = $stmt->execute();
        return $result;
        
    }

    public function addGeneralData($customer_company_name, $customer_sales_agent, $customer_is_prospect, $customer_maintenance_contract){

        $sql = "INSERT INTO `tbl_customers`(customer_company_name, customer_sales_agent, customer_is_prospect, customer_maintenance_contract) 
                VALUES (:customer_company_name, :customer_sales_agent, :customer_is_prospect, :customer_maintenance_contract)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_company_name', $customer_company_name);
        $stmt->bindParam(':customer_sales_agent', $customer_sales_agent);
        $stmt->bindParam(':customer_is_prospect', $customer_is_prospect);
        $stmt->bindParam(':customer_maintenance_contract', $customer_maintenance_contract);
        $result = $stmt->execute();
        return $result;
        
    }

    public function addAddress($pAddress, $pZipcode, $pCity, $sAddress, $sZipcode, $sCity) {

        $sql = "INSERT INTO `tbl_customers`(customer_address, customer_zipcode, customer_city, custoemr_sec_address, customer_sec_zipcode, customer_sec_city)
                VALUES (:customer_address, :customer_zipcode, :customer_city, :customer_sec_address, :customer_sec_zipcode, :customer_sec_city)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_address', $customer_address);
        $stmt->bindParam(':customer_zipcode', $customer_zipcode);
        $stmt->bindParam(':customer_city', $customer_city);
        $stmt->bindParam(':customer_sec_address', $customer_sec_address);
        $stmt->bindParam(':customer_sec_zipcode', $customer_sec_zipcode);
        $stmt->bindParam(':customer_sec_city', $customer_sec_city);
        $result = $stmt->execute();
        return $result;

    }
}