<?php

require_once ('../init.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if(!empty($_POST['username'])
&& !empty($_POST['password'])
&& !empty($_POST['password_check'])){
    
    $username = $_POST['username'];

   if($_POST['password'] == $_POST['password_check']){

       if($user->exists($username)){
           $message = 'User already exists!';
           $user->redirect('admin.php?page=add_user&error='.$message);
           die();
       }
       /*
         * hash all the passwords!
         *
         * */

       $password = $_POST['password'];
       $password = password_hash($password, PASSWORD_DEFAULT);
       
       $user->register($username, $password);
       $message = 'User is added!';
       $user->redirect('../public/admin.php?page=add_user&success='.$message);
       
   }else{
       $message = 'Passwords do not match!';
       $user->redirect('admin.php?page=add_user&error='.$message);
   }

} else {
    $message = 'Fill in the required fields!';
    $user->redirect('admin.php?page=add_user&error='.$message);
}



}

?>
