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
    
    public function addInvoice($project, $invoiceTotal, $invoiceDate) {
        $sql = "INSERT INTO tbl_invoices (project_id, invoice_total, invoice_date) VALUES(:project, :invoiceTotal, :invoiceDate)";

        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project', $project);
        $stmt->bindParam(':invoiceTotal', $invoiceTotal);
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $stmt->execute();
    }



    public function getAllData() {
        $sql = 'SELECT * 
                FROM `tbl_invoices` i
                INNER JOIN `tbl_projects` p
                ON i.project_id = p.project_id
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                WHERE p.project_is_active = 1
                ORDER BY i.invoice_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function deleteInvoice() {
        $sql = "DELETE FROM tbl_invoice WHERE invoice_id = todo";
    }
    

    public function redirect($path){
        header('location: ' . BASE_URL . '/public/' . $path);
    }
}