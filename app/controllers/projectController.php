<?php
require_once ('../init.php');

if($_SERVER['REQUEST_METHOD'] = 'POST'){
    if(empty($_POST['type'])){
        $user->redirect('projects.php?page=add_project');
    }

    $form_name = $_POST['type'];
    $posted_values = $_POST;
    $_SESSION['posted_values'] = $posted_values;
    var_dump($posted_values);
    switch($form_name){
        case 'Add Project':
            $required_fields_ar = array('projectname', 'priority', 'version', 'description', 'start_date');
            foreach($required_fields_ar as $required_field){
                if(!array_key_exists($required_field, $posted_values)){
                    $message = 'Fill in all required fields!';
                    $user->redirect('projects.php?page=add_project&error='.$message);
                }
            }
            break;
    }
}
