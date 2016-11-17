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
        case 'projects_list':
            $project_obj = new Project();
            $projects_ar = $project_obj->searchProjects($_POST['value']);
            if(empty($projects_ar)){
                echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                echo "<h3 class='text-center'>No projects found!</h3>";
            }else{
                if(!empty($_POST['value'])){
                    echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                }
                echo $project_obj->getProjectsTable($user, $projects_ar);
            }
            break;
        case 'invoices_list':
            $invoices_obj = new Invoice();
            $invoices_ar = $invoices_obj->searchInvoices($_POST['value']);
            if(empty($invoices_ar)){
                echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                echo "<h3 class='text-center'>No invoices found!</h3>";
            }else{
                if(!empty($_POST['value'])){
                    echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                }
                $return_ar[] = '<table class="table table-striped table-hover table-responsive">';
                $return_ar[] = '<thead><tr><th>Invoice Number</th><th>Customer</th><th>Project</th><th>Invoice Date</th>
                                           <th>Invoice Total</th><th>Sent</th><th>Paid</th><th>Options</th></tr> </thead>';

                $tr_ar = array();
                foreach ($invoices_ar as $invoice) {
                    $options_ar = $td_ar = array();
                    $options_ar[] = '<a href="../app/controllers/invoiceController.php?page=set_paid&invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-success btn-options '.($invoice->invoice_is_confirmed ? 'disabled' : '').'" title="Set Paid"><span class="glyphicon glyphicon-ok"></span></a>';
                    $options_ar[] = '<a href="invoices.php?page=view_invoice&invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    $options_ar[] = '<a href="invoices.php?page=edit_invoice&invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-warning btn-options '.($invoice->invoice_is_sent ? 'disabled' : '').'"><span class="glyphicon glyphicon-edit"></span></a>';
                    $options_ar[] = '<a href="../app/controllers/invoiceController.php?invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-danger btn-options '.($invoice->invoice_is_sent ? 'disabled' : '').'"><span class="glyphicon glyphicon-remove"></span></a>';

                    $td_ar[] = '<td>#'.$invoice->invoice_number.'</td>';
                    $td_ar[] = '<td>'.$invoice->customer_company_name.'</td>';
                    $td_ar[] = '<td>'.$invoice->project_name.'</td>';
                    $td_ar[] = '<td>'.date('d-m-Y', strtotime($invoice->invoice_date)).'</td>';
                    $td_ar[] = '<td>&euro; '.$invoice->invoice_total.'</td>';
                    $td_ar[] = '<td>'. ( $invoice->invoice_is_sent == 1 ? 'Yes' : 'No' ).'</td>';
                    $td_ar[] = '<td>'.( $invoice->invoice_is_confirmed == 1 ? 'Yes' : 'No' ).'</td>';
                    $td_ar[] = '<td>'.implode('', $options_ar).'</td>';
                    $tr_ar[] = '<tr>'.implode('', $td_ar).'</tr>';
                }
                $return_ar[] = implode('', $tr_ar);
                $return_ar[] = '</table>';

                echo implode('', $return_ar);

            }
            break;
        case 'customers_list':
            $customer_obj = new Customer();
            $customers_ar = $customer_obj->searchCustomers($_POST['value']);
            if(empty($customers_ar)){
                echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                echo "<h3 class='text-center'>No customers found!</h3>";
            }else{
                if(!empty($_POST['value'])){
                    echo '<span class="label label-default">Filter: '.$_POST['value'].'</span>';
                }
                $return_ar[] = '<table class="table table-striped table-hover table-responsive">';
                $return_ar[] = '<thead><tr><th>Companyname</th><th>Address</th><th>Contact Person</th><th>Contact email</th><th>Maintenance contract</th><th>Sales agent</th><th>Prospectstatus</th><th>Option buttons</th></tr></thead>';

                $tr_ar = array();
                foreach($customers_ar as $customer) {
                    $options_ar = $td_ar = array();
                    $options_ar[] = '<a href="customers.php?page=customer_overall&customer_id=' . $customer->customer_id . '" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    $options_ar[] = '<a href="customers.php?page=customer_general_data&customer_id=' . $customer->customer_id . '&type=edit" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>';
                    $options_ar[] = '<a href="../app/controllers/deleteController.php?customer_id=' . $customer->customer_id . '" class="btn btn-small btn-danger btn-options" id="deleteCustomer"><span class="glyphicon glyphicon-remove"></span></a>';

                    $td_ar[] = '<td>'.$customer->customer_company_name.'</td>';
                    $td_ar[] = '<td>'.$customer->customer_address.'</td>';
                    $td_ar[] = '<td>'.$customer->customer_contact_firstname.' '.$customer->customer_contact_surname.'</td>';
                    $td_ar[] = '<td>'.$customer->customer_contact_email.'</td>';
                    $td_ar[] = '<td>'.($customer->customer_maintenance_contract ? 'Yes' : 'No').'</td>';
                    $td_ar[] = '<td>'.$customer->customer_sales_agent.'</td>';
                    $td_ar[] = '<td>'.($customer->customer_is_prospect ? 'Yes' : 'No').'</td>';
                    $td_ar[] = '<td>'.implode('', $options_ar).'</td>';
                    $tr_ar[] = '<tr '.($customer->customer_is_onhold ? 'class="on_hold" ' : '').'>'.implode('', $td_ar).'</tr>';
                }

                $return_ar[] = implode('', $tr_ar);
                $return_ar[] = '</table>';
                echo implode('', $return_ar);
            }
            break;
    }
}
?>