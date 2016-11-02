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
        $sql = "SELECT * FROM tbl_customers WHERE customer_is_active = 1";
        $result = $this->db->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($customer_id)
    {
        $sql = "UPDATE `tbl_customers`  
                SET customer_is_active = 0
                WHERE customer_id = :customer_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $result = $stmt->execute();
        return $result;
        
    }
    
    public function getCustomerById($id){
        $sql = "SELECT tbl_customers.*, COUNT(tbl_projects.project_id) AS open_projects  FROM tbl_customers 
                LEFT JOIN tbl_projects 
                ON tbl_customers.customer_id = tbl_projects.customer_id 
                AND tbl_projects.project_is_finished = 0 
                AND tbl_projects.project_is_active = 1
                WHERE tbl_customers.customer_id = :id 
                GROUP BY tbl_customers.customer_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLatest() {
        $sql = "SELECT * FROM `tbl_customers` ORDER BY customer_id DESC LIMIT 1";
        $result = $this->db->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
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
    
    public function updateGeneralData($cc_name, $cs_agent, $prospect, $contract, $id){
        $sql = "UPDATE `tbl_customers` 
                SET customer_company_name = :cc_name, customer_sales_agent = :cs_agent, customer_is_prospect = :prospect, customer_maintenance_contract = :contract
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':cc_name', $cc_name);
        $stmt->bindParam(':cs_agent', $cs_agent);
        $stmt->bindParam(':prospect', $prospect);
        $stmt->bindParam(':contract', $contract);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;
    }


    public function addAddress($customer_address, $customer_zipcode, $customer_city, $customer_sec_address, $customer_sec_zipcode, $customer_sec_city, $id) {

        $sql = "UPDATE `tbl_customers` SET customer_address = :customer_address, customer_zipcode = :customer_zipcode, customer_city = :customer_city, customer_sec_address = :customer_sec_address, 
                customer_sec_zipcode = :customer_sec_zipcode, customer_sec_city = :customer_sec_city WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_address', $customer_address);
        $stmt->bindParam(':customer_zipcode', $customer_zipcode);
        $stmt->bindParam(':customer_city', $customer_city);
        $stmt->bindParam(':customer_sec_address', $customer_sec_address);
        $stmt->bindParam(':customer_sec_zipcode', $customer_sec_zipcode);
        $stmt->bindParam(':customer_sec_city', $customer_sec_city);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;

    }

    public function addContactPerson($initials, $firstname, $surname, $email, $phone, $sec_phone, $fax, $id){
        $sql = "UPDATE `tbl_customers` 
                SET customer_contact_initials = :cc_initials, customer_contact_firstname = :cc_firstname, customer_contact_surname = :cc_surname, customer_contact_email = :cc_email, 
                customer_contact_phone = :cc_phone, customer_contact_sec_phone = :cc_sec_phone, customer_fax = :cc_fax
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':cc_initials', $initials);
        $stmt->bindParam(':cc_firstname', $firstname);
        $stmt->bindParam(':cc_surname', $surname);
        $stmt->bindParam(':cc_email', $email);
        $stmt->bindParam(':cc_phone', $phone);
        $stmt->bindParam(':cc_sec_phone', $sec_phone);
        $stmt->bindParam(':cc_fax', $fax);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;

    }

    public function addFinancial($discount, $overdraft, $payterm, $bankaccount, $ledgeraccount, $revenue, $tax_id, $id){
        $sql = "UPDATE `tbl_customers`
                SET customer_discount = :c_discount, customer_overdraft = :c_overdraft, customer_pay_term = :c_p_term, 
                customer_bank_account = :c_bankaccount, customer_ledger_account = :c_ledgeraccount, 
                customer_revenue = :c_revenue, tax_code_id = :tax_id
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':c_discount', $discount);
        $stmt->bindParam(':c_overdraft', $overdraft);
        $stmt->bindParam(':c_p_term', $payterm);
        $stmt->bindParam(':c_bankaccount', $bankaccount);
        $stmt->bindParam(':c_ledgeraccount', $ledgeraccount);
        $stmt->bindParam(':c_revenue', $revenue);
        $stmt->bindParam(':tax_id', $tax_id);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;
    }

    public function getAllVisits(){
        $sql = "SELECT * FROM `tbl_visits`";
        $result = $this->db->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function addVisits(){
        $sql = "UPDATE `tbl_customers`
                SET ";
    }

    public function searchCustomerName($search_value){
        $sql = "SELECT * FROM `tbl_customers` WHERE customer_company_name LIKE :search_value";
        $stmt = $this->db->pdo->prepare($sql);
        $search_value = '%'.$search_value.'%';
        $stmt->bindParam(':search_value', $search_value);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}