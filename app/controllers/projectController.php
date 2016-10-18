<?php
require_once ('../init.php');

$project = new Project();

if(isset($_GET['pid'])){
    if($project->projectExists($_GET['pid'])){
        $project->deleteProject($user, $_GET['pid']);
        $message = 'Project is deleted!';
        $user->redirect('projects.php?success='.$message);
        exit();
    }
    $message = 'Project doesn\'t exists!';
    $user->redirect('projects.php?error='.$message);
    exit();
}

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    if(empty($_POST['type'])){
        $user->redirect('projects.php?page=add_project');
    }

    $form_name = $_POST['type'];
    $posted_values = $_POST;
    $_SESSION['posted_values'] = $posted_values;
    switch($form_name){
        case 'Add Project':
            $required_fields_ar = array('customer_id', 'project_name', 'project_priority', 'project_version', 'project_description', 'project_start_date');
            foreach($required_fields_ar as $required_field){
                if(empty($posted_values[$required_field])){
                    $message = 'Fill in all required fields!';
                    $user->redirect('projects.php?page=add_project&error='.$message);
                    exit();
                }
            }
           $project->addProject($user, $posted_values);

            break;
        case 'Edit Project':
            $required_fields_ar = array('customer_id', 'project_name', 'project_priority', 'project_version', 'project_description', 'project_start_date');
            foreach($required_fields_ar as $required_field){
                if(empty($posted_values[$required_field])){
                    $message = 'Fill in all required fields!';
                    $user->redirect('projects.php?page=edit_project&pid='.$posted_values['project_id'].'&error='.$message);
                    exit();
                }
            }
            $project->updateProject($user, $posted_values);
            
            break;
    }
}
