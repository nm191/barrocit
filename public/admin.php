<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 11-10-2016
 * Time: 09:41
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

$current_page = $error = $success = '';

if(isset($_GET['page'])){
    $current_page = $_GET['page'];
} else {
    $current_page = 'admin';
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
                <div class="col-sm-offset-4 col-sm-4"><input type="submit" class="btn btn-block btn-success"> </div>
            </fieldset>
            </form>

<?php

        break;
    case 'users':

        break;
    case 'admin':
        echo 'Admin home';
        break;

    default:
        echo 'This page does not exists!';

}


require_once ('includes/footer.php');

?>