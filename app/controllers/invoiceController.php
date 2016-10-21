<?php
/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 14-10-2016
 * Time: 10:58
 */

require_once ('../init.php');

$invoice = new Invoice();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    /*    var_dump($_GET);
        exit;*/
    $invoice_id = $_GET['invoice_id'];

    if ($invoice->disableInvoice($invoice_id)){
        echo 'Invoice deleted';
        $message = 'Invoice has been disabled!';
        $user->redirect('invoices.php?page=list_invoices&success=' . $message);
    }
}

if($_SERVER['REQUEST_METHOD'] = 'POST'); {
    switch($_POST['type']) {
        case 'addInvoice':
            if (!empty($_POST['project_id'])
                && !empty($_POST['invoiceTotal'])
                && !empty($_POST['invoiceDate'])
            ) {

                $project = $_POST['project_id'];
                $invoiceTotal = $_POST['invoiceTotal'];
                $invoiceDate = $_POST['invoiceDate'];

                $invoice->addInvoice($project,$invoiceTotal , $invoiceDate);
                $message = 'Invoice is added!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
    }
}


