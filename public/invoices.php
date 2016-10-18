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

if(isset($_GET['page'])){
    $current_page = $_GET['page'];
} else {
    $current_page = 'customers';
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
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/invoiceController.php" method="POST" class="form-horizontal">
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project">Project:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="project" id="project">
                            <option>Project</option>
                            <option>Top</option>
                            <option>Fucking</option>
                            <option>Kek</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Select project</button>
                    </div>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Select Project</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Some text in the modal.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Invoice Total:</label>
                    <div class="col-sm-4"><input class="form-control" id="invoiceTotal" name="invoiceTotal" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project">Date:</label>
                        <div class="col-sm-4">
                            <input type='date' name="invoiceDate" id="invoiceDate" class="form-control" />
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
                            <th>Invoice Date</th>
                            <th>Invoice Total</th>
                            <th>Sent?</th>
                            <th>Confirmed?</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <?php
                        $invoiceData = $invoices->getAllData();
                        foreach ($invoiceData as $invoice) {
                            echo '<tr>';
                            echo '<td> #' . str_replace("-","",$invoice['invoice_date']) . $invoice['invoice_id'] . '</td>';
                            echo '<td>' . $invoice['project_id'] . '</td>';
                            echo '<td>' . $invoice['invoice_date'] . '</td>';
                            echo '<td> € ' . $invoice['invoice_total'] . '</td>';
                            echo '<td>' . ( $invoice['invoice_is_sent'] == 1 ? 'Yes' : 'No' ). '</td>';
                            echo '<td>' . ( $invoice['invoice_is_confirmed'] == 1 ? 'Yes' : 'No' ). '</td>';
                            echo '<td>
                            <a href="invoices.php?page=add_invoice?id='.$invoice['invoice_id'].'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a href="invoices.php?page=add_invoice?id='.$invoice['invoice_id'].'" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../app/controllers/deleteController.php?invoice_id='.$invoice['invoice_id'].'" class="btn btn-small btn-danger btn-options"><span class="glyphicon glyphicon-remove"></span></a></td>';
                            echo '</tr>';
                        }
                        ?>
                     </table>
                </div>
            </div>
        <?php
        break;

    default:
        echo 'This page does not exists!';

}
require_once ('includes/footer.php');

?>
