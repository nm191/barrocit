<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 10-10-2016
 * Time: 12:19
 */
    if(!$user->isLoggedIn){
        $user->redirect('index.php');
    }

    //get current page
    $current_page_name = rtrim(basename($_SERVER['PHP_SELF']),'.php');

?>

<div class="container-fluid">

    <header>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Barroc IT.</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">




                    <?php
                        if($user->hasAccess('sales')){
                    ?>
                    <li><a href="customers.php?page=customer_general_data&type=insert">Add Customer <span class="sr-only">(current)</span></a></li>
                    <li><a href="projects.php?page=add_project">Add Project</a></li>
                    <?php
                        }
                    ?>
                    <?php
                        if($user->hasAccess('finance')){
                    ?>
                        <li><a href="invoices.php?page=add_invoice">Add Invoice</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="#">Helpdesk</a></li>


                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown notification-btn">
                        <a href="#" class="dropdown-toggle a-main btn btn-primary" data-toggle="dropdown" role="button" aria-expanded="false">
    Notifications <span class="badge"><?php echo $notification->getNotificationsCount($user->getUserID(), true); ?></span>
                            </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php echo $notification->getNotificationsList($user->getUserID()); ?>
                            <li><a class="all_notifications" href="notifications.php">View all notifications (<?php echo $notification->getNotificationsCount($user->getUserID()); ?>)</a></li>
                        </ul>
                    </li>
                    <li><span class="logged-in-as">Logged in as <?php echo $user->username; ?></span></li>
                    <li><a class="btn btn-danger logout" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>


</header>

<div class="row">
    <div class="col-sm-2">
        <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="visible-xs navbar-brand">Sidebar menu</span>
                </div>
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li <?php echo ($current_page_name == 'home' ? 'class="active"' : ''); ?>><a href="home.php">Home</a></li>
                        <li <?php echo ($current_page_name == 'projects' ? 'class="active"' : ''); ?>>
                            <a href="#" data-toggle="collapse" data-target="#toggleProjects" data-parent="#sidenav01" class="collapsed">
                                </span> Projects <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleProjects" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="projects.php">Project list</a></li>
                                    <?php if($user->hasAccess('sales')){?>
                                    <li><a href="projects.php?page=add_project">Add project</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li <?php echo ($current_page_name == 'customers' ? 'class="active"' : ''); ?>>
                            <a href="#" data-toggle="collapse" data-target="#toggleCustomers" data-parent="#sidenav01" class="collapsed">
                               </span> Customers <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleCustomers" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="customers.php">Customers list</a></li>
                                    <?php if($user->hasAccess('sales')){?>
                                    <li><a href="customers.php?page=customer_general_data&type=insert">Add customer</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <?php
                            if($user->hasAccess('finance')) {

                                ?>
                                <li <?php echo ($current_page_name == 'invoices' ? 'class="active"' : ''); ?>>
                                    <a href="#" data-toggle="collapse" data-target="#toggleFinance"
                                       data-parent="#sidenav01" class="collapsed">
                                        Finance <span class="caret pull-right"></span>
                                    </a>
                                    <div class="collapse" id="toggleFinance" style="height: 0px;">
                                        <ul class="nav nav-list">
                                            <li><a href="invoices.php?page=list_invoices">Invoice list</a></li>
                                            <li><a href="invoices.php?page=add_invoice">Add invoice</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <?php
                            }
                        if($user->hasAccess('admin')) {
                            ?>
                            <li <?php echo ($current_page_name == 'admin' ? 'class="active"' : ''); ?>>
                                <a href="#" data-toggle="collapse" data-target="#toggleAdmin" data-parent="#sidenav01"
                                   class="collapsed">
                                    </span> Admin <span class="caret pull-right"></span>
                                </a>
                                <div class="collapse" id="toggleAdmin" style="height: 0px;">
                                    <ul class="nav nav-list">
                                        <li><a href="admin.php">Users</a></li>
                                        <li><a href="admin.php?page=add_user">Add User</a></li>
                                    </ul>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <div class="col-sm-10">