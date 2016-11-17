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

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    switch ($page){
        case 'set_paid':
            $invoice->setPaid($invoice_id);
            $message = 'Invoice has been set to paid!';
            $user->redirect('invoices.php?page=list_invoices&success=' . $message);
            exit;
            break;
    }

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
                $invoiceSent = (isset($_POST['invoiceSent']) ? 1 : 0);
                $invoicePaid = (isset($_POST['invoicePaid']) ? 1 : 0);

                $invoice->addInvoice($project,$invoiceTotal , $invoiceDate, $invoiceSent, $invoicePaid);
                $message = 'Invoice is added!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
            break;
        case 'Edit Invoice':
//            var_dump($_POST);
//            exit;
            if (!empty($_POST['invoice_id'])
                && !empty($_POST['invoiceTotal'])
                && !empty($_POST['invoiceDate'])
            ) {

                $invoice_id = $_POST['invoice_id'];
                $invoiceTotal = $_POST['invoiceTotal'];
                $invoiceDate = $_POST['invoiceDate'];
                $invoiceSent = (isset($_POST['invoiceSent']) ? 1 : 0);
                $invoicePaid = (isset($_POST['invoicePaid']) ? 1 : 0);

                $invoice->editInvoice($invoice_id, $invoiceTotal, $invoiceDate, $invoiceSent, $invoicePaid);
                $message = 'Invoice has been edited!';
                $invoice->redirect('../public/invoices.php?page=list_invoices&success=' . $message);
            }
             break;
    }
}


