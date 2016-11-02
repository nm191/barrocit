<?php
require_once ('../init.php');

$project = new Project();


if(isset($_GET['pid']) && isset($_GET['page'])){
    if($project->projectExists($_GET['pid'])){
        if($_GET['page'] == 'delete'){

            $current_project = $project->getProjectByID($_GET['pid']);
            $for_section_id = $admin->getUserRightId('development');
            $note_text = 'The project \''.$current_project->project_name.'\' has been deleted for \''.$current_project->customer_company_name.'\'';
            $notification->addNotification($for_section_id->user_right_id, $user->getUserID(), $note_text);

            $project->deleteProject($user, $_GET['pid']);
            $message = 'Project is deleted!';
            $user->redirect('projects.php?success='.$message);
            exit();
        }elseif ($_GET['page'] == 'finish'){
            if($project->getProjectFinished() != 'Yes') {
                $project->finishProject($user, $_GET['pid']);
                $message = 'Project has been set to finished!';
                $user->redirect('projects.php?success=' . $message);
                exit();
            }else{
                $message = 'This project has already been finished!';
                $user->redirect('projects.php?error='.$message);
                exit();
            }
        }
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

            $for_section_id = $admin->getUserRightId('development');
            $note_text = 'A project has been created for \''.$posted_values['customer_name'].'\'';
            $notification->addNotification($for_section_id->user_right_id, $user->getUserID(), $note_text);
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
