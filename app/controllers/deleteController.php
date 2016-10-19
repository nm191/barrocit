<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 13-10-2016
 * Time: 12:32
 */

require_once ('../init.php');

$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    
        $customer_id = $_GET['customer_id'];

    if ($customer->delete($customer_id)){
        echo 'Customer deleted';

        $user->redirect('customers.php');
    }

    $invoice_id = $_GET['invoice_id'];
    if ($invoice->delete($invoice_id)){
        echo 'Invoice deleted';

        header('location: ../public/invoice.php');
    }
}