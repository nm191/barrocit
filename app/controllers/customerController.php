<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 14-10-2016
 * Time: 10:51
 */
require_once ('../init.php');

$customer = new Customer();

$formname = 'invalid_form';

if (isset($_GET['customer_id']))
{
    $addition = '&customer_id=' . $_GET['customer_id'];
} else {
    $addition = '';
}

    if (isset($_POST['formname'])){
        $formname = $_POST['formname'];
    }

    if(isset($_GET['page'])){
        $formname = $_GET['page'];
    }

    switch ($formname){
        case 'generalData':
            if (!isset($_POST['customerName']) || !isset($_POST['salesAgent'])){
            echo "set Customer name and/or Salesagent";
        }

            if (isset($_POST['edit'])){


                $id = $_POST['id'];
                $cc_name = $_POST['customerName'];
                $cs_agent = $_POST['salesAgent'];
                isset($_POST['prospect']) ? $prospect = $_POST['prospect'] : $prospect = 0;
                (isset($_POST['maintenanceContract']) ? $contract = $_POST['maintenanceContract'] : $contract = 0);


                if($customer->updateGeneralData($cc_name, $cs_agent, $prospect, $contract, $id)){
                    echo 'Edit complete';


                }

            }else{

            $customer_company_name = $_POST['customerName'];
            $customer_sales_agent = $_POST['salesAgent'];
            $customer_is_prospect = (isset($_POST['prospect']) ?  $_POST['prospect'] : 0);
            $customer_maintenance_contract = (isset($_POST['maintenanceContract']) ? $_POST['maintenanceContract'] : 0);

            $insert_result = $customer->addGeneralData($customer_company_name, $customer_sales_agent, $customer_is_prospect, $customer_maintenance_contract);
            
        }
            $custData = $customer->getLatest();
            $message = 'Customer general data has been saved!';
            $user->redirect('customers.php?page=customer_addresses&customer_id='.$custData["customer_id"].'&success='.$message);

        break;

        case 'Addresses':
            if (!isset($_POST['primaryAddress']) || !isset($_POST['primaryZipcode']) || !isset($_POST['primaryCity'])){
                $user->redirect('customers.php?page=customer_addresses');
            }
            
            $id = $_POST['id'];
            $pAddress = $_POST['primaryAddress'];
            $pZipcode = $_POST['primaryZipcode'];
            $pCity = $_POST['primaryCity'];
            if(isset($_POST['secundaryAddress'])) {$sAddress = $_POST['secundaryAddress'];}
            if(isset($_POST['secundaryZipcode'])){$sZipcode = $_POST['secundaryZipcode'];}
            if(isset($_POST['secundaryCity'])){$sCity = $_POST['secundaryCity'];}

        if ($customer->addAddress($pAddress, $pZipcode, $pCity, $sAddress, $sZipcode, $sCity, $id)){
            $message = 'Customer address data has been saved!';
            $user->redirect('customers.php?page=customer_contact_person&customer_id='.$id.'&success='.$message);
        }

        break;
        
        case 'contact_person':

            $custData = $customer->getLatest();

            $id = $_POST['id'];
            $initials = $_POST['initials'];
            $firstname = $_POST['firstName'];
            $surname = $_POST['surName'];
            $email = $_POST['email'];
            $phone = $_POST['pTelephone'];
            if(isset($_POST['sTelephone'])){$sec_phone = $_POST['sTelephone'];}
            if(isset($_POST['faxNumber'])){$fax = $_POST['faxNumber'];}

            if($customer->addContactPerson($initials, $firstname, $surname, $email, $phone, $sec_phone, $fax, $id)) {
                $message = 'Customer contact person data has been saved!';
                $user->redirect('customers.php?page=customer_financial&customer_id='.$id.'&success='.$message);
            }
            else{
                $message = 'Something went wrong saving the data. Try again.';
                $user->redirect('customers.php?page=customer_contact_person&customer_id='.$id.'&error='.$message);
            }

            break;


        case 'financial':
            
            $id = $_POST['id'];
            $discount = $_POST['discountRate'];
            $overdraft = $_POST['overdraftLimit'];
            $payterm = $_POST['paymentTerm'];
            $bankaccount = $_POST['bankaccountNumber'];
            $ledgeraccount = $_POST['legderAccountNumber'];
            $revenue = $_POST['grossRevenue'];
            $tax_id = $_POST['taxCode'];
            $credit_worthy = (isset($_POST['creditWorthy']) ? 1 : 0);

            if($customer->addFinancial($discount, $overdraft, $payterm, $bankaccount, $ledgeraccount, $revenue, $tax_id, $credit_worthy, $id)){
                $message = 'Financial data has been saved!';
                $user->redirect('customers.php?page=customer_financial&customer_id='.$id.'&success='.$message);
            }else{
                $user->redirect('customers.php?page=customer_financial&customer_id='.$id.'&error='.$message);
            }


            
            break;
        
        
        
        case 'create_visit':
            $posted_values = $_POST;
            unset($posted_values['formname']);
            unset($posted_values['saveAddresses']);
            if(!$posted_values['visit_id']) {
                $insert_visit = $customer->addCustomerVisit($posted_values);
                if($insert_visit){
                    $message = 'Customer visit has been created!';
                    $user->redirect('customers.php?page=customer_visits&customer_id='.$posted_values['customer_id'].'&success='.$message);
                    die();
                }
            }
            $update_result = $customer->updateCustomerVisit($posted_values);
            if($update_result){
                $message = 'Customer visit has been updated!';
                $user->redirect('customers.php?page=customer_visits&customer_id='.$posted_values['customer_id'].'&success='.$message);
                die();
            }
            break;
        
        
        case 'soft_hard':
            
            $posted_values = $_POST;
            unset($posted_values['formname']);
            unset($posted_values['saveSH']);
            if(!$posted_values['customer_id']){
                $message = 'No customer selected';
                $user->redirect('customers.php?page=customer_soft_hard_form&error='.$message);
            }

            if(!$posted_values['shid']){
                $insert_sh = $customer->addSoftHardware($posted_values);
                $message = 'Software/hardware has been saved!';
                $user->redirect('customers.php?page=customer_soft_hard_table&customer_id='.$posted_values['customer_id'].'&success='.$message);
                exit();
            }
            $update_sh = $customer->updateSoftHardware($posted_values);
            if($update_sh){
                $message = 'Software/hardware has been changed!';
                $user->redirect('customers.php?page=customer_soft_hard_form&shid='.$posted_values['shid'].'&customer_id='.$posted_values['customer_id'].'&success='.$message);
            }

            break;

        case 'delete_sh':
            var_dump($_GET);
            if(!isset($_GET['customer_id'])){
                $user->redirect('customers.php');
                exit;
            }
            if(!isset($_GET['shid'])){
                $message = 'There went something wrong! Try again';
                $user->redirect('customers.php?page=customer_soft_hard_table&customer_id='.$_GET['customer_id'].'&error='.$message);
                exit();
            }

            $customer->deleteSoftHardware($_GET['shid']);
            $message = 'Soft/hardware has been deleted!';
            $user->redirect('customers.php?page=customer_soft_hard_table&customer_id='.$_GET['customer_id'].'&success='.$message);
            exit();
            break;
    }