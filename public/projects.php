<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 7-10-2016
 * Time: 11:58
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

    $current_page = $error = $success = '';

    $project = new Project();

    if(isset($_GET['page'])){
    $current_page = $_GET['page'];
    } else {
    $current_page = 'projects';
    }

    //Message handling
    if(isset($_GET['error'])){
    $error = $_GET['error'];
    }

    if(isset($_GET['success'])){
    $success = $_GET['success'];
    }

    if(isset($_SESSION['posted_values'])){
        $posted_values = $_SESSION['posted_values'];
        unset($_SESSION['posted_values']);
    }

    ?>

    <h1 class="text-center">Projects</h1>

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

switch($current_page){
    case 'add_project':
        ?>
        <form action="<?php echo BASE_URL; ?>/app/controllers/projectController.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-center">Add Project</legend>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['projectname'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="projectname">Project Name:</label>
                    <div class="col-sm-4"><input class="form-control" id="projectname" name="projectname" type="text" <?php if(isset($posted_values) && !empty($posted_values['projectname'])){ echo 'value="'.$posted_values['projectname'].'"';} ?> ></div>
                </div>
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['customer'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customer">Customer:</label>
                    <div class="col-sm-4"><input class="form-control" id="customer" name="customer" type="text" <?php if(isset($posted_values) && !empty($posted_values['customer'])){ echo 'value="'.$posted_values['customer'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['priority'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="priority">Priority:</label>
                    <div class="col-sm-4"><input class="form-control" id="priority" name="priority" type="number" min="1" max="999" <?php if(isset($posted_values) && !empty($posted_values['priority'])){ echo 'value="'.$posted_values['priority'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['start_date'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="start_date">Start date:</label>
                    <div class="col-sm-4"><input class="form-control" id="start_date" name="start_date" type="date" <?php if(isset($posted_values) && !empty($posted_values['start_date'])){ echo 'value="'.$posted_values['start_date'].'"';} ?>></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="deadline">Deadline:</label>
                    <div class="col-sm-4"><input class="form-control" id="deadline" name="deadline" type="date"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="version" <?php if(isset($posted_values) && empty($posted_values['version'])){ echo 'has-error';} ?>>Version:</label>
                    <div class="col-sm-4"><input class="form-control" id="version" name="version" type="text" maxlength="15" <?php if(isset($posted_values) && !empty($posted_values['version'])){ echo 'value="'.$posted_values['version'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['description'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="description">Description:</label>
                    <div class="col-sm-4">
                        <textarea name="description" id="description" cols="69" rows="10"><?php if(isset($posted_values) && !empty($posted_values['description'])){ echo 'value="'.$posted_values['description'].'"';} ?></textarea>
                    </div>
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='type' value='Add Project' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>

        <?php
        break;
    case 'projects':
        echo 'Project list';
        break;
    default:
        echo '<h2>This page doesn\'t exists!';
}
?>



<?php
require_once ('includes/footer.php');
?>