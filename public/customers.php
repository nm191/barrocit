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

<h1 class="text-center">Customers</h1>

<ul class="nav nav-tabs flex tab-menu">
    <li role="presentation" <?php echo ($current_page == 'customer_general_data' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_general_data">General Data</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_addresses' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_addresses">Addresses</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_contact_person' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_contact_person">Contact Person</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_visits' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_visits">Visits</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_financial' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_financial">Financial</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_soft_hard' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_soft_hard">Software/Hardware</a></li>
</ul>

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
    case 'customer_general_data':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer General Data</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>

        <?php

        break;
    case 'customer_addresses':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Addresses</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_contact_person':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Contact Person</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_visits':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Visits</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_financial':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Financial</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_soft_hard':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Software / Hardware</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Customer name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="prospect" name="prospect" >
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="maintenanceContract" name="maintenanceContract" >
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customers':
        echo $customers;
        break;

    default:
        echo 'This page does not exists!';

}


require_once ('includes/footer.php');

?>
