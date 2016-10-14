<?php
/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 14-10-2016
 * Time: 10:58
 */

require_once ('../init.php');

$invoice = new Invoices();

var_dump($_POST);

if($_SERVER['REQUEST_METHOD'] = 'POST'); {
    switch($_POST['type']) {
        case 'addInvoice':
            if (!empty($_POST['invoiceNumber'])
                && !empty($_POST['invoiceTotal'])
                && !empty($_POST['project'])
                && !empty($_POST['invoiceDate'])
            ) {

                $invoiceNumber = $_POST['invoiceNumber'];
                $invoiceTotal = $_POST['invoiceTotal'];
                $project = $_POST['project'];
                $invoiceDate = $_POST['invoiceDate'];

                $invoice->addInvoice($invoiceNumber, $invoiceTotal, $project, $invoiceDate);
                $message = 'Invoice is added!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
    }
}