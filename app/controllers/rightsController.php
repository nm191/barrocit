<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 20-10-2016
 * Time: 12:20
 */

require_once ('../init.php');

$admin = new Admin();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    switch($_POST['formname']){
        case 'user_rights':
            //var_dump($_POST);
            //set successfull message
            $message = 'User rights are saved.';

            //get posted values
            $posted_user_rights = $_POST;

            //set section id
            $section = $posted_user_rights['section_id'];

            //unset values
            unset($posted_user_rights['section_id']);
            unset($posted_user_rights['formname']);


            var_dump($posted_user_rights);

            //delete all user rights for section
            if(!$admin->deleteUserRights($section)){
                $message = 'Something went wrong. Try again.';
                $user->redirect('admin.php?page=user_rights&section='.$section.'&error='.$message);
                exit();
            }

            //check if users are selected, if not do nothing
            if(!$posted_user_rights){
                $user->redirect('admin.php?page=user_rights&section='.$section.'&success='.$message);
                exit();
            }

            foreach($posted_user_rights as $user_id){
                //Insert user rights for section
                if(!$admin->insertUserRight($user_id, $section)){
                    continue;
                };
            }

            $user->redirect('admin.php?page=user_rights&section='.$section.'&success='.$message);
            exit();
            //insert user rights for all users selected
            //give feedback to user.
            break;
    }

}