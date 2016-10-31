<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 11-10-2016
 * Time: 09:41
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

$current_page = $error = $success = $section = '';

$admin = new Admin();

if(isset($_GET['page'])){
    $current_page = $_GET['page'];
} else {
    $current_page = 'users';
}

if(isset($_GET['section'])){
    $section = $_GET['section'];
}

//Message handling
if(isset($_GET['error'])){
    $error = $_GET['error'];
}

if(isset($_GET['success'])){
    $success = $_GET['success'];
}

?>

<h1 class="text-center">Admin Panel</h1>

    <ul class="nav nav-tabs flex tab-menu">
        <li role="presentation" <?php echo ($current_page == 'users' || $current_page == 'add_user' ? 'class="active"' : ''); ?>><a href="admin.php">Users</a></li>
        <li role="presentation" <?php echo ($current_page == 'user_rights' ? 'class="active"' : ''); ?>><a href="admin.php?page=user_rights">User Rights</a></li>
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
    case 'user_rights':

        ?>
        <div class="col-sm-10 col-sm-offset-1">
            <form action="<?php echo BASE_URL; ?>/app/controllers/rightsController.php" method="POST" class="form-horizontal">
               <fieldset>
                   <legend class="text-center">Edit user rights</legend>
                   <div class="col-sm-2">
                       <?php
                            echo $admin->getUserRightsTable();
                        ?>
                   </div>
                   <div class="col-sm-9 col-sm-offset-1">
                       <?php
                            echo $admin->getUserRightsFormTable($section);
                        ?>
                       <div class="form-group">
                            <input type="hidden" name="section_id" value="<?php echo $section ?>">
                           <input type="hidden" name="formname" value="user_rights">
                            <input type="submit" class="btn btn-block btn-success" value="Save User Rights">
                       </div>
                   </div>
               </fieldset>
            </form>
        </div>
        <?php
        break;
    case 'add_user':

        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/authController.php" method="POST" class="form-horizontal">
           <fieldset>
           <legend class="text-center">Add user</legend>
            <div class="form-group">
                <label class="col-sm-offset-2 col-sm-2 control-label" for="username">Username:</label>
                <div class="col-sm-4"><input class="form-control" id="username" name="username" type="text" required></div>
            </div>
            <div class="form-group">
                <label class="col-sm-offset-2 col-sm-2 control-label" for="password">Password:</label>
                <div class="col-sm-4"><input class="form-control" id="password" name="password" type="password" required></div>
            </div>
            <div class="form-group">
                <label class="col-sm-offset-2 col-sm-2 control-label" for="password_check">Password check:</label>
                <div class="col-sm-4"><input class="form-control" id="password_check" name="password_check" type="password" required></div>
            </div>
               <div class="form-group">
                   <label class="col-sm-offset-2 col-sm-2 control-label" for="userLevel">User Level:</label>
                   <div class="col-sm-4">
                       <select class="form-control" name="userLevel" id="userLevel">
                           <?php
                           echo $admin->getUserLevelOptions();
                           ?>
                       </select>
                   </div>
               </div>
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='type' value='Register' class="btn btn-block btn-success"> </div>
            </fieldset>
            </form>

<?php

        break;
    case 'users':
        ?>
        <div class="col-sm-10 col-sm-offset-1">
        <a href="admin.php?page=add_user" class="btn btn-primary btn-block">Add user</a>
        <?php
        echo $admin->getUsersTable();
        ?>
        </div>
        <?php
        break;
    case 'admin':
        var_dump($user);
        break;
    default:
        echo 'This page does not exists!';

}


require_once ('includes/footer.php');

?>