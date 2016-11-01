<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 12-10-2016
 * Time: 09:57
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

$current_page = $error = $success = '';

$invoices = new Invoice();
$customer = new Customer();
$project = new Project();

    if(isset($_GET['page'])){
        $current_page = $_GET['page'];
    } else {
        $current_page = 'customers';
    }

    if(isset($_GET['pid'])){
        $invoice = new Invoice($_GET['pid']);
        $posted_values = $invoice->getAllInvoiceData();
    }else{
        $invoice = new Invoice();
    }

//Message handling
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }

    if(isset($_GET['success'])){
        $success = $_GET['success'];
    }

?>

<h1 class="text-center">Create/edit Invoices</h1>

<?php

if(!empty($error)){
    ?>
    <div class="alert alert-danger" role="alert">Error: <?php echo $error; ?></div>
    <?php
}

if(!empty($success)){
    ?>
    <div class="alert alert-success" role="alert">Success: <?php echo $success; ?></div>
    <?php
}
switch ($current_page){
    case 'add_invoice':
        echo $modal->getCustomersModal($customer, 'customersModal', 'Select Customer');
        echo $modal->getProjectsModal($project, 'projectsModal', 'Select Project');

        if(!isset($_GET['invoice_id'])){

            $invoiceData = 0;
            

        } else {
            $id = $_GET['invoice_id'];
            $invoiceData = $invoice->getInvoiceByID($id);

        }


    ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/invoiceController.php" method="POST" class="form-horizontal">
            <fieldset>
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['customer_id'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customer_name">Customer:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="customer_name_disabled" name="customer_name_disabled" type="text" disabled placeholder="<?php echo $invoiceData['customer_company_name']; ?>" required<?php if(isset($posted_values) && !empty($posted_values['customer_name'])){ echo 'value="'.$posted_values['customer_name'].'"';} ?>>
                        <input class="form-control" id="customer_name" name="customer_name" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['customer_name'])){ echo 'value="'.$posted_values['customer_name'].'"';} ?>>
                        <input class="form-control" id="customer_id" name="customer_id" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['customer_id'])){ echo 'value="'.$posted_values['customer_id'].'"';} ?>>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customersModal">Select Customer</button>
                    </div>
                </div>
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['project_id'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_name">Project:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="project_name_disabled" name="project_name_disabled" type="text" disabled placeholder="<?php echo $invoiceData['project_name']; ?>" required>
                        <input class="form-control" id="project_name" name="project_name" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['project_name'])){ echo 'value="'.$posted_values['project_name'].'"';} ?>>
                        <input class="form-control" id="project_id" name="project_id" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['project_id'])){ echo 'value="'.$posted_values['project_id'].'"';} ?>>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#projectsModal">Select Project</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="invoiceTotal">Invoice Total:</label>
                    <div class="col-sm-4"><input class="form-control" id="invoiceTotal" name="invoiceTotal" type="text" placeholder="<?php echo $invoiceData['invoice_total']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project">Date:</label>
                        <div class="col-sm-4">
                            <input type='date' name="invoiceDate" id="invoiceDate" class="form-control" placeholder="<?php echo $invoiceData['invoice_date']; ?>" required>
                        </div>
                    </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Sent?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Confirmed?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='type' value='addInvoice' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'edit_invoice':
        echo $modal->getCustomersModal($customer, 'customersModal', 'Select Customer');
        echo $modal->getProjectsModal($project, 'projectsModal', 'Select Project');

        if(!isset($_GET['invoice_id'])){

            $invoiceData = 0;


        } else {
            $id = $_GET['invoice_id'];
            $invoiceData = $invoice->getInvoiceByID($id);
            /*            var_dump($invoiceData);
                        exit;*/
        }
        var_dump($invoiceData);

        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/invoiceController.php" method="POST" class="form-horizontal">
            <fieldset>
<!--                <div class="form-group  <?php /*if(isset($posted_values) && empty($posted_values['customer_id'])){ echo 'has-error';} */?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customer_name">Customer:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="customer_name_disabled" name="customer_name_disabled" type="text" disabled placeholder="<?php /*echo $invoiceData['customer_company_name']; */?>" required<?php /*if(isset($posted_values) && !empty($posted_values['customer_name'])){ echo 'value="'.$posted_values['customer_name'].'"';} */?>>
                        <input class="form-control" id="customer_name" name="customer_name" type="hidden" <?php /*if(isset($posted_values) && !empty($posted_values['customer_company_name'])){ echo 'value="'.$posted_values['customer_company_name'].'"';} */?>>
                        <input class="form-control" id="customer_id" name="customer_id" type="hidden" <?php /*if(isset($posted_values) && !empty($posted_values['customer_id'])){ echo 'value="'.$posted_values['customer_id'].'"';} */?>>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customersModal">Select Customer</button>
                    </div>
                </div>-->
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['project_id'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_name">Project:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="project_name_disabled" name="project_name_disabled" type="text" disabled placeholder="<?php echo $invoiceData['project_name']; ?>" required>
                        <input class="form-control" id="project_name" name="project_name" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['project_name'])){ echo 'value="'.$posted_values['project_name'].'"';} ?>>
                        <input class="form-control" id="project_id" name="project_id" type="hidden" <?php if(isset($posted_values) && !empty($posted_values['project_id'])){ echo 'value="'.$posted_values['project_id'].'"';} ?>>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#projectsModal">Select Project</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="invoiceTotal">Invoice Total:</label>
                    <div class="col-sm-4"><input class="form-control" id="invoiceTotal" name="invoiceTotal" type="text" placeholder="<?php echo $invoiceData['invoice_total']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project">Date:</label>
                    <div class="col-sm-4">
                        <input type='date' name="invoiceDate" id="invoiceDate" class="form-control" value="<?php echo $invoiceData['invoice_date']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Sent?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Confirmed?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='type' value='addInvoice' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'list_invoices':
        ?>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="well well-lg">
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Customer</th>
                            <th>Project</th>
                            <th>Invoice Date</th>
                            <th>Invoice Total</th>
                            <th>Sent</th>
                            <th>Paid</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <?php
                        $invoiceData = $invoices->getAllInvoiceData();
                        foreach ($invoiceData as $invoice) {
                            echo '<tr>';
                            echo '<td> #' . $invoice->invoice_number . '</td>';
                            echo '<td>' . $invoice->customer_company_name . '</td>';
                            echo '<td>' . $invoice->project_name . '</td>';
                            echo '<td>' . $invoice->invoice_date . '</td>';
                            echo '<td> € ' . $invoice->invoice_total . '</td>';
                            echo '<td>' . ( $invoice->invoice_is_sent == 1 ? 'Yes' : 'No' ). '</td>';
                            echo '<td>' . ( $invoice->invoice_is_confirmed == 1 ? 'Yes' : 'No' ). '</td>';
                            echo '<td>
                            <a href="invoices.php?page=add_invoice?id='.$invoice->invoice_id.'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a href="invoices.php?page=edit_invoice&invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../app/controllers/invoiceController.php?invoice_id='.$invoice->invoice_id.'" class="btn btn-small btn-danger btn-options"><span class="glyphicon glyphicon-remove"></span></a></td>';
                            echo '</tr>';
                        }
                        ?>
                     </table>
                </div>
            </div>
        <?php
        break;
    case 'view_invoice':
        if(!$invoice->invoiceExists($invoice_id)){
            $user->redirect('invoices.php?page=invalid_invoice');
        }

        ?>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="well well-lg">
                <?php
                echo '<h3>'.$project->getProjectName().'</h3>  ';
                ?>
                <table class="table table-responisve table-striped table-hover">
                    <?php
                    echo '<tr><td>Customer:</td><td>'.$project->getProjectCustomerName().'</td></tr>';
                    echo '<tr><td>Priority:</td><td>'.$project->getProjectPrio().'</td></tr>';
                    echo '<tr><td>Deadline:</td><td> '.date('d-m-Y', strtotime($project->getProjectDeadline())).'</td></tr>';
                    echo '<tr><td>Start:</td><td> '.date('d-m-Y', strtotime($project->getProjectStart())).'</td></tr>';
                    echo '<tr><td>Version:</td><td> '.$project->getProjectVersion().'</td></tr>';
                    echo '<tr><td>Finished:</td><td> '.$project->getProjectFinished().'</td></tr>';
                    echo '<tr><td>Description:</td><td> '.$project->getProjectDescription().'</td></tr>';
                    ?>
                </table>
            </div>
        </div>
        <?php
        break;
    default:
        echo 'This page does not exists!';

}
?>
<script>
    $(document).ready(function(){
        $("input:radio[name=customer]").click(function(){
            console.log("Clicked");
            var customer_id = $("input:radio[name=customer]:checked").val();
            var customer_name = $("input:radio[name=customer]:checked").data('customer_name');
            console.log(customer_id);
            $('#customer_id').val(customer_id);
            $('#customer_name_disabled').val(customer_name);
            $('#customer_name').val(customer_name);
            $('#customersModal').modal('toggle');
        });

        $("input:radio[name=project]").click(function(){
            console.log("Clicked");
            var project_id = $("input:radio[name=project]:checked").val();
            var project_name = $("input:radio[name=project]:checked").data('project_name');
            console.log(project_id);
            $('#project_id').val(project_id);
            $('#project_name_disabled').val(project_name);
            $('#project_name').val(project_name);
            $('#projectsModal').modal('toggle');
        });

        $("a#deleteProject").click(function(e){
            if(!confirm('Are you sure you want to delete this project?')){
                e.preventDefault();
                return false;
            }
            return true;
        });

        $("#searchBoxcustomersModal").change(function() {
            var value = $('#searchBoxcustomersModal').val();
            $.post('../app/controllers/searchController.php?search=customers',{value:value}, function(data){
                $("#searchResultscustomersModal").html(data);

                $("input:radio[name=customer]").click(function(){
                    console.log("Clicked");
                    var customer_id = $("input:radio[name=customer]:checked").val();
                    var customer_name = $("input:radio[name=customer]:checked").data('customer_name');
                    console.log(customer_id);
                    $('#customer_id').val(customer_id);
                    $('#customer_name_disabled').val(customer_name);
                    $('#customer_name').val(customer_name);
                    $('#customersModal').modal('toggle');
                });
            });
            return false;
        });

        $("#searchBoxprojectsModal").change(function() {
            var value = $('#searchBoxprojectsModal').val();
            $.post('../app/controllers/searchController.php?search=projects',{value:value}, function(data){
                $("#searchResultsprojectsModal").html(data);

                $("input:radio[name=project]").click(function(){
                    console.log("Clicked");
                    var project_id = $("input:radio[name=project]:checked").val();
                    var project_name = $("input:radio[name=project]:checked").data('project_name');
                    console.log(project_id);
                    $('#project_id').val(project_id);
                    $('#project_name_disabled').val(project_name);
                    $('#project_name').val(project_name);
                    $('#projectsModal').modal('toggle');
                });
            });
            return false;
        });

    });






</script>
<?php
require_once ('includes/footer.php');

?>
