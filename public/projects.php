<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 7-10-2016
 * Time: 11:58
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

    $project_id = $current_page = $error = $success = '';

    if(isset($_GET['pid'])){
        $project = new Project($_GET['pid']);
    }else{
        $project = new Project();
    }


    if(isset($_GET['page'])){
        $current_page = $_GET['page'];
    } else {
        $current_page = 'projects';
    }

    if(!isset($_GET['pid']) && $current_page == 'view_project'){
        $current_page = 'invalid_project';
    }else if($current_page == 'view_project'){
        $project_id = $_GET['pid'];
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
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['project_name'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_name">Project Name:</label>
                    <div class="col-sm-4"><input class="form-control" id="project_name" name="project_name" type="text" <?php if(isset($posted_values) && !empty($posted_values['project_name'])){ echo 'value="'.$posted_values['project_name'].'"';} ?> ></div>
                </div>
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['customer_id'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="customer_id">Customer:</label>
                    <div class="col-sm-4"><input class="form-control" id="customer_id" name="customer_id" type="number" <?php if(isset($posted_values) && !empty($posted_values['customer_id'])){ echo 'value="'.$posted_values['customer_id'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['project_priority'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_priority">Priority:</label>
                    <div class="col-sm-4"><input class="form-control" id="project_priority" name="project_priority" type="number" min="1" max="999" <?php if(isset($posted_values) && !empty($posted_values['project_priority'])){ echo 'value="'.$posted_values['project_priority'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['project_start_date'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_start_date">Start date:</label>
                    <div class="col-sm-4"><input class="form-control" id="project_start_date" name="project_start_date" type="date" <?php if(isset($posted_values) && !empty($posted_values['project_start_date'])){ echo 'value="'.$posted_values['project_start_date'].'"';} ?>></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_deadline">Deadline:</label>
                    <div class="col-sm-4"><input class="form-control" id="project_deadline" name="project_deadline" type="date"></div>
                </div>
                <div class="form-group  <?php if(isset($posted_values) && empty($posted_values['project_version'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_version">Version:</label>
                    <div class="col-sm-4"><input class="form-control" id="project_version" name="project_version" type="text" maxlength="15" <?php if(isset($posted_values) && !empty($posted_values['project_version'])){ echo 'value="'.$posted_values['project_version'].'"';} ?>></div>
                </div>
                <div class="form-group <?php if(isset($posted_values) && empty($posted_values['project_description'])){ echo 'has-error';} ?>">
                    <label class="col-sm-offset-2 col-sm-2 control-label" for="project_description">Description:</label>
                    <div class="col-sm-4">
                        <textarea name="project_description" id="project_description" cols="69" rows="10"><?php if(isset($posted_values) && !empty($posted_values['project_description'])){ echo $posted_values['project_description'];} ?></textarea>
                    </div>
                </div>

                <div class="col-sm-offset-4 col-sm-4"><input type="submit" name='type' value='Add Project' class="btn btn-block btn-success"> </div>
            </fieldset>
        </form>

        <?php
        break;
    case 'projects':
        ?>
        <div class="col-sm-10 col-sm-offset-1">
            <?php
            echo $project->getProjectsTable();
            ?>
        </div>
        <?php
        break;
    case 'view_project':
        if(!$project->projectExists($project_id)){
            $user->redirect('projects.php?page=invalid_project');
        }

        ?>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="well well-lg">
                <?php
                 echo '<h3>'.$project->getProjectName().'</h3>  ';
                 ?>
                <table class="table table-responisve table-striped table-hover">
                    <?php
                        echo '<tr><td>Customer:</td><td>'.$project->getProjectCustomer().'</td></tr>';
                        echo '<tr><td>Priority:</td><td>'.$project->getProjectPrio().'</td></tr>';
                        echo '<tr><td>Deadline:</td><td> '.$project->getProjectDeadline().'</td></tr>';
                        echo '<tr><td>Start:</td><td> '.$project->getProjectStart().'</td></tr>';
                        echo '<tr><td>Version:</td><td> '.$project->getProjectVersion().'</td></tr>';
                        echo '<tr><td>Finished:</td><td> '.$project->getProjectFinished().'</td></tr>';
                        echo '<tr><td>Description:</td><td> '.$project->getProjectDescription().'</td></tr>';
                    ?>
                </table>
            </div>
        </div>
        <?php
        break;
    case 'invalid_project':
        echo '<h2>This is not a valid project!</h2>';
        break;
    default:
        echo '<h2>This page doesn\'t exists!';
}
?>



<?php
require_once ('includes/footer.php');
?>