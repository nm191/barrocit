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

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if (isset($_POST['formname'])){
        $formname = $_POST['formname'];
    }


    switch ($formname){
        case 'generalData':
            if (!isset($_POST['customerName']) || !isset($_POST['salesAgent'])){
            echo "set Customer name and/or Salesagent";
        }

            $customer_company_name = $_POST['customerName'];
            $customer_sales_agent = $_POST['salesAgent'];
            (isset($_POST['prospect']) ? $customer_is_prospect = $_POST['prospect'] : $customer_is_prospect = 0);
            (isset($_POST['maintenanceContract']) ? $customer_maintenance_contract = $_POST['maintenanceContract'] : $customer_maintenance_contract = 0);

        if ($customer->addGeneralData($customer_company_name, $customer_sales_agent, $customer_is_prospect, $customer_maintenance_contract)){
            echo 'Added with success';

            $user->redirect('customers.php?page=customer_addresses');
        }

        break;

        case 'Addresses':
            if (!isset($_POST['primaryAddress']) || !isset($_POST['primaryZipcode']) || !isset($_POST['primaryCity'])){
                header('location: '. BASE_URL . '/public/customers.php?page=customer_addresses');
            }

            $custData = $customer->getLatest();

            $id = $custData['customer_id'];
            $pAddress = $_POST['primaryAddress'];
            $pZipcode = $_POST['primaryZipcode'];
            $pCity = $_POST['primaryCity'];
            if(isset($_POST['secundaryAddress'])) {$sAddress = $_POST['secundaryAddress'];}
            if(isset($_POST['secundaryZipcode'])){$sZipcode = $_POST['secundaryZipcode'];}
            if(isset($_POST['secundaryCity'])){$sCity = $_POST['secundaryCity'];}

        if ($customer->addAddress($pAddress, $pZipcode, $pCity, $sAddress, $sZipcode, $sCity, $id)){

            $user->redirect('customers.php?page=customer_contact_person');
        }

        break;
        
        case 'contact_person':

            $custData = $customer->getLatest();
            
            $id = $_custData['customer_id'];
            $initials = $_POST['initials'];
            $firstname = $_POST['firstName'];
            $surname = $_POST['surName'];
            $email = $_POST['email'];
            $phone = $_POST['pTelephone'];
            if(isset($_POST['sTelephone'])){$sec_phone = $_POST['sTelephone'];}
            if(isset($_POST['faxNumber'])){$fax = $_POST['fax'];}

        if($customer->addContactPerson($initials, $firstname, $surname, $email, $phone, $sec_phone)){}

    }



}