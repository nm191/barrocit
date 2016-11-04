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

    $invoice_id = $_GET['invoice_id'];

    if ($invoice->disableInvoice($invoice_id)){
        echo 'Invoice disabled';
        $message = 'Invoice has been disabled!';
        $user->redirect('invoices.php?page=list_invoices&success=' . $message);
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] = 'POST'); {
    if(empty($_POST['type'])){
        $user->redirect('invoices.php?page=add_invoices');
    }

    $form_name = $_POST['type'];
    $posted_values = $_POST;
    $_SESSION['posted_values'] = $posted_values;
    switch($form_name){
        case 'Add Invoice':
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
            break;
        case 'Edit Invoice':
            /*var_dump($_POST);
            exit;*/
            if (!empty($_POST['invoice_id'])
                && !empty($_POST['invoiceTotal'])
                && !empty($_POST['invoiceDate'])
            ) {

                $invoice_id = $_POST['invoice_id'];
                $invoiceTotal = $_POST['invoiceTotal'];
                $invoiceDate = $_POST['invoiceDate'];

                $invoice->editInvoice($invoice_id, $invoiceTotal, $invoiceDate);
                $message = 'Invoice has been edited!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
             break;
    }
}


