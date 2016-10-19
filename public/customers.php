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

$customer = new Customer();

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

<div class="col-sm-10 col-sm-offset-1">

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

    case 'customer_overall':

    $id = $_GET['customer_id'];
    $custTableData = $customer->getCustomerById($id);


    echo '<table class="table table-striped table-hover table-responsive">';
    echo '<h3>'. $custTableData['customer_company_name'] . '</h3>';
    echo '<tr><td><b>General Data</b></td><td></td></td></tr>';
    echo '<tr><td>Contact Person:</td><td>' . $custTableData['customer_contact_firstname'] . ' ' . $custTableData['customer_contact_surname'] . '</td></tr>';
    echo '<tr><td>Prospect Status:</td><td>' . $custTableData['customer_is_prospect'] . '</td></tr>';
    echo '<tr><td>Maintenance Contract:</td><td>' . $custTableData['customer_maintenance_contract'] . '</td></tr>';
    echo '<tr><td>Sales Agent:</td><td>' . $custTableData['customer_sales_agent'].'</td></tr>';
    echo '<tr><td>Open Projects:</td><td>'. $custTableData['customer_open_projects'] .'</td></tr>';
    echo '<tr><td><b>Addresses</b></td><td></td></tr>';
    echo '<tr><td>Address</td><td>'. $custTableData['customer_address'] .'</td></tr>';
    echo '<tr><td>Zipcode</td><td>'. $custTableData['customer_zipcode'] .'</td></tr>';
    echo '<tr><td>City</td><td>'. $custTableData['customer_city'] .'</td></tr>';
    if($custTableData['customer_sec_address'] != 'NULL'){echo '<tr><td>Secundary Address</td><td>'. $custTableData['customer_sec_address'] . '</td></tr>';}
    if($custTableData['customer_sec_zipcode'] != 'NULL'){echo '<tr><td>Secundary Zipcode</td><td>' . $custTableData['customer_sec_zipcode'] . '</td></tr>';}
    if($custTableData['customer_sec_city'] != 'NULL'){echo '<tr><td>Secundary City</td><td>' . $custTableData['customer_sec_city'] . ' </td></tr>';}
    echo '<tr><td><b>Contact Information</b></td><td></td></tr>';
    echo '<tr><td>Emailaddress</td><td>'. $custTableData['customer_contact_email'] .'</td></tr>';
    echo '<tr><td>Phonenumber</td><td>'. $custTableData['customer_contact_phone'] .'</td></tr>';
    echo '<tr><td>Secundary Phonenumber</td><td>'. $custTableData['customer_contact_sec_phone'] .'</td></tr>';
    echo '<tr><td>Faxnumber</td><td>'. $custTableData['customer_fax'] .'</td></tr>';
    echo '<tr><td><b>Financial Data</b></td><td></td></tr>';
    echo '<tr><td>Discount</td><td>'. $custTableData['customer_discount'] .'</td></tr>';
    echo '<tr><td>Overdraft</td><td>'. $custTableData['customer_overdraft'] .'</td></tr>';
    echo '<tr><td>Pay term</td><td>'. $custTableData['customer_pay_term'] .'</td></tr>';
    echo '<tr><td>Bank Account</td><td>'. $custTableData['customer_bank_account'] .'</td></tr>';
    echo '<tr><td>Ledger Account</td><td>'. $custTableData['customer_ledger_account'] .'</td></tr>';
    echo '<tr><td>Revenue</td><td>'. $custTableData['customer_revenue'] .'</td></tr>';
    echo '</table>';



    break;


    case 'customer_general_data':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
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
                            <input type="checkbox" value="1" name="prospect">
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="1" name="maintenanceContract">
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="formname">
                    <input type="hidden" name="formname" value="generalData">
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>

        <?php

        break;
    case 'customer_addresses':
        ?>
        <?php

        if(!isset($_GET['customer_id'])){

            $custData = $customer->getLatest();

        } else {
            $id = $_GET['customer_id'];
            $custData = $customer->getCustomerById($id);
        }


        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Addresses</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="primaryAddress">Primary Address:</label>
                    <div class="col-sm-4"><input class="form-control" id="primaryAddress" name="primaryAddress" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="primaryZipcode">Primary Zipcode:</label>
                    <div class="col-sm-4"><input class="form-control" id="primaryZipcode" name="primaryZipcode" type="text" required></div>
                </div>
                <div class="form-group" style="margin-bottom: 40px;">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="primaryCity">Primary City:</label>
                    <div class="col-sm-4"><input class="form-control" id="primaryCity" name="primaryCity" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryAddress">Secundary Address:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryAddress" name="secundaryAddress" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryZipcode">Secundary Zipcode:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryZipcode" name="secundaryZipcode" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryCity">Secundary City:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryCity" name="secundaryCity" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryCity">Secundary City:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryCity" name="secundaryCity" type="text"></div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $custData['customer_id'];?>">
                </div>

                <div class="formname">
                    <input type="hidden" name="formname" value="Addresses">
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_contact_person':
        
        $custData = $customer->getLatest();
        
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Contact Person</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="initials">Initials:</label>
                    <div class="col-sm-4"><input class="form-control" id="initials" name="initials" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="firstName">Firstname:</label>
                    <div class="col-sm-4"><input class="form-control" id="firstName" name="firstName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="surName">Lastname:</label>
                    <div class="col-sm-4"><input class="form-control" id="surName" name="surName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="email">Email:</label>
                    <div class="col-sm-4"><input class="form-control" id="email" name="email" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="pTelephone">Primary telephone:</label>
                    <div class="col-sm-4"><input class="form-control" id="pTelephone" name="pTelephone" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="sTelephone">Secondary telephone:</label>
                    <div class="col-sm-4"><input class="form-control" id="sTelephone" name="sTelephone" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="faxNumber">Fax number:</label>
                    <div class="col-sm-4"><input class="form-control" id="faxNumber" name="faxNumber" type="text"></div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php $custData['customer_id'] ?>">
                </div>

                <div class="formname">
                    <input type="hidden" name="formname" value="contact_person">
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveContactPerson' value='Save' class="btn btn-block btn-success"> </div>
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
?>
<table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
                <th>Companyname</th>
                <th>Address</th>
                <th>Contact Person</th>
                <th>Contact email</th>
                <th>Maintenance contract</th>
                <th>Sales agent</th>
                <th>Open projects</th>
                <th>Prospectstatus</th>
                <th>Option buttons</th>

        </tr>
        </thead>


        <?php
        $custData = $customer->getAlldata();

        foreach($custData as $cust){
            $options_ar = array();
            $options_ar[] = '<a href="customers.php?page=customer_overall&customer_id='. $cust['customer_id'].'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>';
            $options_ar[] = '<a href="customers.php?page=customer_addresses&customer_id='. $cust['customer_id'].'" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>';
            $options_ar[] = '<a href="../app/controllers/deleteController.php?customer_id='.$cust['customer_id'].'" class="btn btn-small btn-danger btn-options"><span class="glyphicon glyphicon-remove"></span></a>';
            echo '<tr>';
            echo '<td>' . $cust['customer_company_name'] . '</td>';
            echo '<td>' . $cust['customer_address'] . '</td>';
            echo '<td>' . $cust['customer_contact_firstname'] . ' ' . $cust['customer_contact_surname'] . '</td>';
            echo '<td>' . $cust['customer_contact_email'] . '</td>';
            echo '<td>' . $cust['customer_maintenance_contract'] . '</td>';
            echo '<td>' . $cust['customer_sales_agent'] . '</td>';
            echo '<td>' . $cust['customer_open_projects'] . '</td>';
            echo '<td>' . $cust['customer_is_prospect'] . '</td>';
            echo '<td>'.implode('', $options_ar).'</td>';

            echo '</tr>';
        }
        ?>

</table>

</div>
<?php
        break;

    default:
        echo 'This page does not exists!';

}


require_once ('includes/footer.php');

?>
