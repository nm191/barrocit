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

if (isset($_GET['customer_id']))
{
    $addition = '&type=edit&customer_id=' . $_GET['customer_id'];
    $customer_id = $_GET['customer_id'];
} else {
    $customer_id = 0;
    $addition = '';
}

$customer = new Customer($customer_id);
$project = new Project();
?>



<h1 class="text-center">Customers</h1>

<div class="col-sm-10 col-sm-offset-1">
<?php
    if($current_page != 'customers'){
?>
<ul class="nav nav-tabs flex tab-menu">
    <li role="presentation" <?php echo ($current_page == 'customer_general_data' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_general_data&type=insert<?php echo $addition;?>">General Data</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_addresses' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_addresses<?php echo $addition;?>">Addresses</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_contact_person' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_contact_person<?php echo $addition;?>">Contact Person</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_financial' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_financial<?php echo $addition;?>">Financial</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_visits' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_visits<?php echo $addition;?>">Visits</a></li>
    <li role="presentation" <?php echo ($current_page == 'customer_soft_hard_table' || $current_page == 'customer_soft_hard_form' ? 'class="active"' : ''); ?>><a href="customers.php?page=customer_soft_hard_table<?php echo $addition;?>">Software/Hardware</a></li>
</ul>

<?php
    } // end if current page
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

    echo '<div class="col-sm-10 col-sm-offset-1">';

    if($custTableData['customer_is_onhold']){
        echo '<div class="alert alert-danger" role="alert">This customer has been put on hold! Contact Sales for more information.</div>';
    }

    if(!$customer->getCustomerIsFilled()){
        echo '<div class="alert alert-warning" role="alert">Not all information is entered for this customer</div>';
    }

    echo '<table class="table table-striped table-hover table-responsive">';
    echo '<h3 class="text-center">'. $custTableData['customer_company_name'] . '</h3>';
    echo '<tr><td><b>General Data</b></td><td></td></td></tr>';
    echo '<tr><td style="width: 50%; margin-left: 25%;">Contact Person:</td><td style="width: 50%;">' . $custTableData['customer_contact_firstname'] . ' ' . $custTableData['customer_contact_surname'] . '</td></tr>';
    echo '<tr><td>Prospect Status:</td><td>' . ($custTableData['customer_is_prospect'] ? 'Yes' : 'No') . '</td></tr>';
    echo '<tr><td>Maintenance Contract:</td><td>' . ($custTableData['customer_maintenance_contract'] ? 'Yes' : 'No') . '</td></tr>';
    echo '<tr><td>Sales Agent:</td><td>' . $custTableData['customer_sales_agent'].'</td></tr>';
    echo '<tr><td>Open Projects</td><td>'. $project->getOpenProjectsCount($id) .'</td></tr>';
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
    echo '<tr><td>Discount</td><td>'. $custTableData['customer_discount'] .'%</td></tr>';
    echo '<tr><td>Overdraft</td><td>&euro; '. $custTableData['customer_overdraft'] .'</td></tr>';
    echo '<tr><td>Pay term</td><td>'. $custTableData['customer_pay_term'] .' days</td></tr>';
    echo '<tr><td>Bank Account</td><td>'. $custTableData['customer_bank_account'] .'</td></tr>';
    echo '<tr><td>Ledger Account</td><td>'. $custTableData['customer_ledger_account'] .'</td></tr>';
    echo '<tr><td>Revenue</td><td>&euro; '. $custTableData['customer_revenue'] .'</td></tr>';
    echo '</table>';

    echo '</div>';



    break;


    case 'customer_general_data':
//        if ($_GET['type'] == 'edit'){
//            $id = $_GET['customer_id'];
//            $custData = $customer->getCustomerById($id);
//        }

        if(!isset($_GET['customer_id'])) {
                    $custData = $customer->getLatest();
                }
                 else {
                    $id = $_GET['customer_id'];
                    $custData = $customer->getCustomerById($id);
                }

        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer General Data</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customerName">Company name:</label>
                    <div class="col-sm-4"><input class="form-control" id="customerName" value="<?php if($_SERVER['REQUEST_METHOD'] == 'GET')
                        { if($_GET['type'] == 'insert'){  }
                        else{echo $custData['customer_company_name']; }} ?>" name="customerName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Sales agent:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="salesAgent" id="salesAgent">
                            <option><?php if($_SERVER['REQUEST_METHOD'] == 'GET')
                                { if ($_GET['type'] == 'edit'){ echo $custData['customer_sales_agent']; }} ?>   </option>
                            <option>Nick</option>
                            <option>Ronald</option>
                            <option>Tim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="1" name="prospect"
                                <?php if($_SERVER['REQUEST_METHOD'] == 'GET')
                            { if($_GET['type'] == 'insert'){ $custData['customer_is_prospect'] = 0; }
                            else{if($custData['customer_is_prospect'] == 1){ echo 'checked';}}} ?>>
                            Prospect?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="1" name="maintenanceContract" <?php if($_SERVER['REQUEST_METHOD'] == 'GET')
                            { if($_GET['type'] == 'insert'){ $custData['customer_maintenance_contract'] = 0; }
                            else{if($custData['customer_maintenance_contract'] == 1){ echo 'checked';}}} ?>>
                            Maintenance contract?
                        </label>
                    </div>
                </div>
                <div class="formname">
                    <input type="hidden" name="formname" value="generalData">
                </div>
                <div class="formname">
                    <?php
                        if($_GET['type'] == 'edit') {
                            echo '<input type="hidden" name="edit" value="edit">';
                        }
                    ?>
                </div>
                <div class="formname">
                    <input type="hidden" name="id" value="<?php if(isset($_GET['customer_id'])){ echo $_GET['customer_id'];}?>">
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveGeneralData' value='Save' class="btn btn-block btn-success"></div>
            </fieldset>
        </form>

<!--        // <?php //if($_SERVER['REQUEST_METHOD'] == 'POST'){if ($_GET['type'] == 'edit'){ echo 'edit';}}?> <- Dit op lijn 169 ipv edit bij value geplaatst, maar dat hoeft denk ik niet. Klopt het dat edit als value op deze manier goed is? -->

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
                    <div class="col-sm-4"><input class="form-control" id="primaryAddress" name="primaryAddress" value="<?php echo $custData['customer_address']; ?>" placeholder="<?php echo $custData['customer_address']; ?>" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="primaryZipcode">Primary Zipcode:</label>
                    <div class="col-sm-4"><input class="form-control" id="primaryZipcode" name="primaryZipcode" value="<?php echo $custData['customer_zipcode']; ?>" type="text" required></div>
                </div>
                <div class="form-group" style="margin-bottom: 40px;">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="primaryCity">Primary City:</label>
                    <div class="col-sm-4"><input class="form-control" id="primaryCity" name="primaryCity" value="<?php echo $custData['customer_city']; ?>" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryAddress">Secundary Address:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryAddress" name="secundaryAddress" value="<?php echo $custData['customer_sec_address']; ?>" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryZipcode">Secundary Zipcode:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryZipcode" name="secundaryZipcode" value="<?php echo $custData['customer_sec_zipcode']; ?>" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="secundaryCity">Secundary City:</label>
                    <div class="col-sm-4"><input class="form-control" id="secundaryCity" name="secundaryCity" value="<?php echo $custData['customer_sec_city']; ?>" type="text"></div>
                </div>
                <div class="formname">
                    <input type="hidden" name="edit" value="edit">
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $custData['customer_id'];?>">
                </div>

                <div class="formname">
                    <input type="hidden" name="formname" value="Addresses">
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveAddresses' value='Save' class="btn btn-block btn-success"> </div>
            </fieldset>

<!--            --><?php //if(isset($_GET['customer_id'])){ echo '<a href="customers.php?page=customer_contact_person' . $addition . '"';}?><!--<button class="btn btn-success btn-block">Edit only</button></a>-->

        </form>
        <?php
        break;
    case 'customer_contact_person':
        if(!isset($_GET['customer_id'])){

            $custData = $customer->getLatest();

        } else {
            $id = $_GET['customer_id'];
            $custData = $customer->getCustomerById($id);
        }
        
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Contact Person</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="initials">Initials:</label>
                    <div class="col-sm-4"><input class="form-control" id="initials" value="<?php echo $custData['customer_contact_initials']; ?>" name="initials" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="firstName">Firstname:</label>
                    <div class="col-sm-4"><input class="form-control" id="firstName" value="<?php echo $custData['customer_contact_firstname']; ?>" name="firstName" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="surName">Lastname:</label>
                    <div class="col-sm-4"><input class="form-control" id="surName" name="surName" value="<?php echo $custData['customer_contact_surname']; ?>" type="text" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="email">Email:</label>
                    <div class="col-sm-4"><input class="form-control" id="email" name="email" type="text" value="<?php echo $custData['customer_contact_email']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="pTelephone">Primary telephone:</label>
                    <div class="col-sm-4"><input class="form-control" id="pTelephone" name="pTelephone" type="text" value="<?php echo $custData['customer_contact_phone']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="sTelephone">Secondary telephone:</label>
                    <div class="col-sm-4"><input class="form-control" id="sTelephone" name="sTelephone" value="<?php echo $custData['customer_contact_sec_phone']; ?>" type="text"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="faxNumber">Fax number:</label>
                    <div class="col-sm-4"><input class="form-control" id="faxNumber" name="faxNumber" value="<?php echo $custData['customer_fax']; ?>" type="text"></div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $custData['customer_id'];?>">
                </div>

                <div class="formname">
                    <input type="hidden" name="formname" value="contact_person">
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveContactPerson' value='Save' class="btn btn-block btn-success"></div>
            </fieldset>
        </form>
        <?php
        break;
case 'customer_financial':

        if(!isset($_GET['customer_id'])){

            $custData = $customer->getLatest();

        } else {
            $id = $_GET['customer_id'];
            $custData = $customer->getCustomerById($id);
        }



        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Financial</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Discount rate:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                           <input class="form-control" id="discountRate" name="discountRate" type="number" max="100" value="<?php echo $custData['customer_discount']; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Overdraft limit:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">&euro;</div>
                            <input class="form-control" id="discountRate" name="overdraftLimit" type="number" value="<?php echo $custData['customer_overdraft']; ?>">
                            <div class="input-group-addon">,00</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Payment Term:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input class="form-control" id="discountRate" name="paymentTerm" type="text" value="<?php echo $custData['customer_pay_term']; ?>">
                            <div class="input-group-addon">days</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Bank account number:</label>
                    <div class="col-sm-4"><input class="form-control" id="discountRate" name="bankaccountNumber" type="text" value="<?php echo $custData['customer_bank_account']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Ledger Account number:</label>
                    <div class="col-sm-4"><input class="form-control" id="discountRate" name="legderAccountNumber" type="text" value="<?php echo $custData['customer_ledger_account']; ?>" required></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Gross revenue:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">&euro;</div>
                            <input class="form-control" id="discountRate" name="grossRevenue" type="text" value="<?php echo $custData['customer_revenue']; ?>">
                            <div class="input-group-addon">,00</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="discountRate">Tax code:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="taxCode" id="taxCode">
                            <?php
                                echo $customer->getTaxCodeOptions($custData['tax_code_id']);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="creditWorthy" name="creditWorthy" <?php if($custData['customer_credit_worthy'] != 0){ echo 'checked'; } ?> >
                            Credit worthy?
                        </label>
                    </div>
                </div>
                <div class="formname">
                    <input type="hidden" name="formname" value="financial">
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $custData['customer_id'];?>">
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveAddresses' value='Save' class="btn btn-block btn-success"></div>
            </fieldset>
        </form>
        <?php
        break;

case 'customer_visits':

    $visitData = $customer->getAllVisits($customer_id);
    if(!$customer_id){
        $user->redirect('customers.php?page=invalid_customer');
    }
    ;?>


    <a class="btn btn-block btn-primary" href="customers.php?page=customer_create_visit&customer_id=<?php echo $customer_id; ?>">Create visit</a>

<table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
                <th>ID</th>
                <th>Visit Type</th>
                <th>Visit Date</th>
                <th>Visit Text</th>
                <th>Action Date</th>
                <th>Action Finished?</th>
                <th>Options</th>

        </tr>
        </thead>


        <?php

        foreach($visitData as $visit){
            $options_ar = array();
            $options_ar[] = '<a href="customers.php?page=customer_overall&customer_id='. $visit['visit_id'].'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>';
            $options_ar[] = '<a href="customers.php?page=customer_create_visit&customer_id='. $visit['customer_id'].'&visit_id='.$visit['visit_id'].'" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>';
            $options_ar[] = '<a href="../app/controllers/deleteController.php?customer_id='.$visit['visit_id'].'" class="btn btn-small btn-danger btn-options"><span class="glyphicon glyphicon-remove"></span></a>';
            echo '<tr>';
            echo '<td>' . $visit['visit_id'] . '</td>';
            echo '<td>' . $visit['visit_type_id'] . '</td>';
            echo '<td>' . $visit['visit_date']. '</td>';
            echo '<td>' . $visit['visit_text'] . '</td>';
            echo '<td>' . $visit['visit_action_date'] . '</td>';
            echo '<td>' . ($visit['visit_action_is_finished'] ? 'Yes' : 'No'). '</td>';
            echo '<td>'.implode('', $options_ar).'</td>';

            echo '</tr>';
        }
        ?>

    </table>


<?php
    break;


case 'customer_create_visit':

    $id = $_GET['customer_id'];
    $visitData = '';
    if(isset($_GET['visit_id'])){
        $visit_id = $_GET['visit_id'];
        $visitData = $customer->getVisitById($visit_id);
    }else{
        $visit_id = 0;
    }
    ?>

    <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Create/edit visit</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Visit type:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="visitType" id="visitType">
                            <?php
                                echo $customer->getVisitTypeOptions($visitData);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Visit date:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            <input class="form-control" type="date" name="visit_date" value="<?php echo ($visitData ? $visitData['visit_date'] : date('Y-m-d')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Visit text:</label>
                    <div class="col-sm-4"><textarea name="visit_text" id="" cols="30" rows="10"><?php echo ($visitData ? $visitData['visit_text'] : ''); ?></textarea></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Action For:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="actionFor" id="visitType">
                            <option value="Nick" >Nick</option>
                            <option value="Ronald">Ronald</option>
                            <option value="Tim">Tim</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="salesAgent">Action date:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            <input class="form-control" type="date" name="action_date" value="<?php echo ($visitData ? $visitData['visit_action_date'] : date('Y-m-d')); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-sm-offset-4 col-sm-4">
                        <label>
                            <input type="checkbox" value="actionFinished" name="actionFinished" <?php echo (isset($visitData['visit_action_is_finished']) && $visitData['visit_action_is_finished'] == 1  ?  'checked' : ''); ?>>
                            Action Finished
                        </label>
                    </div>
                </div>

                <div class="formname">
                    <input type="hidden" name="formname" value="create_visit">
                </div>

                <div class="form-group">
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
                    <input type="hidden" name="visit_id" value="<?php echo $visit_id;?>">
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveAddresses' value='Save' class="btn btn-block btn-success"></div>
            </fieldset>
        </form>
<?php
break;
case 'customer_soft_hard_form':

        if(!isset($_GET['customer_id'])){

            $custData = $customer->getLatest();

        } else {
            $id = $_GET['customer_id'];
        }

        $shid = 0;
        if(isset($_GET['shid'])){
            $shid = $_GET['shid'];
            $softhard = $customer->getSoftHardwareById($shid);
        }

        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/customerController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Customer Software / Hardware</legend>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="type">Type:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="type" id="type">
                            <?php
                            echo $customer->getSoftHardTypeOptions($softhard);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="shname">Name:</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="shname" value="<?= (isset($softhard->softhard_name) ? $softhard->softhard_name : ''); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="shdesc">Description:</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="shdesc" value="<?= (isset($softhard->softhard_desc) ? $softhard->softhard_desc : ''); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="shdesc">Version:</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="shversion" value="<?= (isset($softhard->softhard_version) ? $softhard->softhard_version : ''); ?>" required>
                    </div>
                </div>
                <div class="formname">
                    <input type="hidden" name="formname" value="soft_hard">
                </div>

                <div class="form-group">
                    <input type="hidden" name="customer_id" value="<?php echo $id;?>">
                    <input type="hidden" name="shid" value="<?php echo $shid;?>">
                </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='saveSH' value='Save' class="btn btn-block btn-success"></div>
            </fieldset>
        </form>
        <?php
        break;
    case 'customer_soft_hard_table':
        echo '<a href="customers.php?page=customer_soft_hard_form&customer_id='.$customer_id.'" class="btn btn-block btn-primary">Add Software / Hardware</a>';
        echo $customer->getSoftHardwaresTable($customer_id);
    break;
    case 'customers':
?>
    <input type="text" class="form-control" id="searchCustomers" placeholder="Search">
    <div id="customers_list">
        <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
                <th>Companyname</th>
                <th>Address</th>
                <th>Contact Person</th>
                <th>Contact email</th>
                <th>Maintenance contract</th>
                <th>Sales agent</th>
                <th>Prospectstatus</th>
                <th>Option buttons</th>

        </tr>
        </thead>


        <?php
        $custData = $customer->getAlldata();

        foreach($custData as $cust){
            $options_ar = array();
            $options_ar[] = '<a href="customers.php?page=customer_overall&customer_id='. $cust['customer_id'].'" class="btn btn-small btn-primary btn-options"><span class="glyphicon glyphicon-eye-open"></span></a>';
            $options_ar[] = '<a href="customers.php?page=customer_general_data&customer_id='. $cust['customer_id'].'&type=edit" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>';
            $options_ar[] = '<a href="../app/controllers/deleteController.php?customer_id='.$cust['customer_id'].'" class="btn btn-small btn-danger btn-options" id="deleteCustomer"><span class="glyphicon glyphicon-remove"></span></a>';
            echo '<tr '.($cust['customer_is_onhold'] ? 'class="on_hold" ' : '').'>';
            echo '<td>' . $cust['customer_company_name'] . '</td>';
            echo '<td>' . $cust['customer_address'] . '</td>';
            echo '<td>' . $cust['customer_contact_firstname'] . ' ' . $cust['customer_contact_surname'] . '</td>';
            echo '<td>' . $cust['customer_contact_email'] . '</td>';
            echo '<td>' . ($cust['customer_maintenance_contract'] ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $cust['customer_sales_agent'] . '</td>';
            echo '<td>' . ($cust['customer_is_prospect'] ? 'Yes' : 'No'). '</td>';
            echo '<td>'.implode('', $options_ar).'</td>';

            echo '</tr>';
        }
        ?>

</table>
</div>
</div>
<?php
        break;
    case 'invalid_customer':
        echo '<h3>This Customer doesn\'t exists!</h3>';
        break;
    default:
        echo 'This page does not exists!';

}


require_once ('includes/footer.php');

?>

<script>
    $(document).ready(function() {
        $("a#deleteCustomer").click(function (e) {
            if (!confirm('Are you sure you want to delete this customer?')) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        $("a#deleteSoftHardware").click(function (e) {
            if (!confirm('Are you sure you want to delete this software/hardware?')) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        $("#searchCustomers").change(function(){
            var value = $("#searchCustomers").val();
            $.post('../app/controllers/searchController.php?search=customers_list',{value:value}, function(data) {
                $("#customers_list").html(data);
            });
        });

    });
</script>
