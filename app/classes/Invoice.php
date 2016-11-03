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

    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();

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

    public function editInvoice($project, $invoiceTotal, $invoiceDate) {
        
        $sql = "UPDATE `tbl_invoices` 
                SET invoice_total = :invoiceTotal, invoice_date = :invoiceDate
                WHERE project_id = :project";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project', $project);
        $stmt->bindParam(':invoiceTotal', $invoiceTotal);
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $result = $stmt->execute();
        return $result;
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
        return $this->invoice_number;
    }

    public function getInvoiceDate(){
        return $this->invoice_date;
    }

    public function getInvoiceTotal(){
        return $this->invoice_total;
    }

    public function getInvoiceSent(){
        return $this->invoice_is_sent ? 'Yes' : 'No';
    }

    public function getInvoicePaid(){
        return $this->invoice_is_confirmed ? 'Yes' : 'No';
    }

    public function getInvoiceActive(){
        return $this->invoice_is_active ? 'Yes' : 'No';
    }

    public function getInvoiceData(){
        $return_ar = array();
        $return_ar['invoice_id'] = $this->getInvoiceId();
        $return_ar['invoice_number'] = $this->getInvoiceNumber();
        $return_ar['invoice_date'] = $this->getInvoiceDate();
        $return_ar['invoice_total'] = $this->getInvoiceTotal();
        $return_ar['invoice_sent'] = $this->getInvoiceSent();
        $return_ar['invoice_confirmed'] = $this->getInvoicePaid();
        $return_ar['invoice_is_active'] = $this->getInvoiceActive();

        return $return_ar;
    }*/
}