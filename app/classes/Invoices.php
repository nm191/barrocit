<?php

/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 14-10-2016
 * Time: 09:53
 */
class Invoices
{
    private $db;

    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();

    }
    
    public function addInvoice($invoiceNumber, $project, $invoiceTotal, $invoiceDate) {
        $sql = "INSERT INTO tbl_invoices (invoice_number, project_id, invoice_total, invoice_date) VALUES(:invoiceNumber, :project, :invoiceTotal, :invoiceDate)";

        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':invoiceNumber', $invoiceNumber);
        $stmt->bindParam(':project', $project);
        $stmt->bindParam(':invoiceTotal', $invoiceTotal);
        $stmt->bindParam(':invoiceDate', $invoiceDate);
        $stmt->execute();
    }

    public function redirect($path){
        header('location: ' . BASE_URL . '/public/' . $path);
    }
}