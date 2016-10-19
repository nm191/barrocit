<?php
require_once ('../init.php');

if(isset($_GET['search']) && isset($_POST['value'])){
    switch($_GET['search']){
        case 'customers':
            $customer_obj = new Customer();
            $customers_ar = $customer_obj->searchCustomerName($_POST['value']);
            if(empty($customers_ar)){
                echo "<h3>No customers found!</h3>";
            }
            else {
                $table = '<table class="table">';
                $table .= '<thead><tr><th>Select</th><th>Customer</th></tr>';
                foreach ($customers_ar as $customer) {
                    $table .= '<tr><td><input data-customer_name="' . $customer->customer_company_name . '" type="radio" name="customer" id="customer" value="' . $customer->customer_id . '"></td><td>' . $customer->customer_company_name . '</td></tr>';
                }
                $table .= '</table>';

                echo $table;
            }
            die();
            break;
    }
}
?>