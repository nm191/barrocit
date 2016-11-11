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
                    if(!$customer->customer_credit_worthy || $customer->customer_is_prospect || !$customer->customer_is_active || $customer->customer_is_onhold){
                        continue;
                    }
                    $table .= '<tr><td><input data-customer_name="' . $customer->customer_company_name . '" type="radio" name="customer" id="customer" value="' . $customer->customer_id . '"></td><td>' . $customer->customer_company_name . '</td></tr>';
                }
                $table .= '</table>';

                echo $table;
            }
            die();
            break;
        case 'projects':
            $project_obj = new Project();
            $projects_ar = $project_obj->searchProjectName($_POST['value']);
            if(empty($projects_ar)){
                echo "<h3>No projects found!</h3>";
            }
            else {
                $table = '<table class="table">';
                $table .= '<thead><tr><th>Select</th><th>Project</th></tr>';
                foreach ($projects_ar as $project) {
                    if(!$project->project_is_active){
                        continue;
                    }
                    $table .= '<tr><td><input data-project_name="' . $project->project_name . '" type="radio" name="project" id="project" value="' . $project->project_id . '"></td><td>' . $project->project_name . '</td></tr>';
                }
                $table .= '</table>';

                echo $table;
            }
            die();
            break;
    }
}
?>