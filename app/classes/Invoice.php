<?php

/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 14-10-2016
 * Time: 09:53
 */
class Invoice
{
    private $db;
    private $invoice_id;

    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();

/*        if(invoice_id && $this->projectExists($invoice_id)){
            $current_project = $this->getProjectByID($invoice_id);
            $this->$invoice_id = $invoice_id;
            $this->project_name = $current_project->project_name;
            $this->project_priority = $current_project->project_priority;
            $this->project_deadline = $current_project->project_deadline;
            $this->project_start_date = $current_project->project_start_date;
            $this->project_description = $current_project->project_description;
            $this->project_version = $current_project->project_version;
            $this->project_is_finished = $current_project->project_is_finished;
            $this->project_customer_name = $current_project->customer_company_name;
            $this->project_customer_id = $current_project->customer_id;

        }*/

    }

    private function countInvoices($project){
        $sql = "SELECT COUNT(*) AS count FROM tbl_invoices WHERE project_id = :project";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project', $project);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    public function addInvoice($project, $invoiceTotal, $invoiceDate) {
        $invoiceCount = $this->countInvoices($project);
        $invoiceNumber = date("Ymd"). $project .$invoiceCount;

        $sql = "INSERT INTO tbl_invoices (project_id, invoice_total, invoice_date, invoice_number) VALUES(:project, :invoiceTotal, :invoiceDate, :invoiceNumber)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project', $project);
        $stmt->bindParam(':invoiceTotal', $invoiceTotal);
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $stmt->bindParam(':invoiceNumber', $invoiceNumber);
        $stmt->execute();
    }

    public function getInvoiceByID($id) {
        $sql = 'SELECT * 
                FROM `tbl_invoices` i
                INNER JOIN `tbl_projects` p
                ON i.project_id = p.project_id
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                WHERE i.invoice_id = :id
                ORDER BY i.invoice_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllInvoiceData() {
        $sql = 'SELECT * 
                FROM `tbl_invoices` i
                INNER JOIN `tbl_projects` p
                ON i.project_id = p.project_id
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                WHERE p.project_is_active = 1
                AND i.invoice_is_active = 1
                ORDER BY i.invoice_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function invoiceExists($invoice_id){
        $sql = "SELECT COUNT(invoice_id) as count FROM tbl_invoices WHERE invoice_id = :invoice_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':invoice_id', $invoice_id);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result->count;
    }

    public function getLatestInvoice() {
        $sql = "SELECT * FROM `tbl_invoices` ORDER BY invoice_id DESC LIMIT 1";
        $result = $this->db->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function disableInvoice($invoice_id) {
        $sql = "UPDATE `tbl_invoices` SET invoice_is_active = 0 WHERE invoice_id = :invoice_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':invoice_id', $invoice_id);
        $result = $stmt->execute();
        return $result;
    }


    public function redirect($path){
        header('location: ' . BASE_URL . '/public/' . $path);
    }

/*    public function getInvoiceId(){
        return $this->invoice_id;
    }
    public function getInvoiceNumber(){
        return $this->project_name;
    }

    public function getProjectPrio(){
        return $this->project_priority;
    }

    public function getProjectCustomerName(){
        return $this->project_customer_name;
    }

    public function getProjectCustomerId(){
        return $this->project_customer_id;
    }

    public function getProjectStart(){
        return $this->project_start_date;
    }

    public function getProjectDeadline(){
        return $this->project_deadline;
    }

    public function getProjectVersion(){
        return $this->project_version;
    }

    public function getProjectDescription(){
        return $this->project_description;
    }

    public function getProjectFinished(){
        return ($this->project_is_finished ? 'Yes' : 'No');
    }

    public function getInvoiceData(){
        $return_ar = array();
        $return_ar['project_id'] = $this->getProjectId();
        $return_ar['project_name'] = $this->getProjectName();
        $return_ar['project_priority'] = $this->getProjectPrio();
        $return_ar['project_start_date'] = $this->getProjectStart();
        $return_ar['project_deadline'] = $this->getProjectDeadline();
        $return_ar['project_version'] = $this->getProjectVersion();
        $return_ar['project_description'] = $this->getProjectDescription();
        $return_ar['project_is_finished'] = $this->getProjectFinished();
        $return_ar['customer_name'] = $this->getProjectCustomerName();
        $return_ar['customer_id'] = $this->getProjectCustomerId();

        return $return_ar;
    }*/
}