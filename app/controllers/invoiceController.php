<?php
/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 14-10-2016
 * Time: 10:58
 */

require_once ('../init.php');

$invoice = new Invoice();

if($_SERVER['REQUEST_METHOD'] = 'POST'); {
    switch($_POST['type']) {
        case 'addInvoice':
            if (!empty($_POST['project'])
                && !empty($_POST['invoiceTotal'])
                && !empty($_POST['invoiceDate'])
            ) {

                $project = $_POST['project'];
                $invoiceTotal = $_POST['invoiceTotal'];
                $invoiceDate = $_POST['invoiceDate'];

                $invoice->addInvoice($project,$invoiceTotal , $invoiceDate);
                $message = 'Invoice is added!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
    }
}