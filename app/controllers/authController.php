<?php

require_once ('../init.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if(!empty($_POST['username'])
&& !empty($_POST['password'])
&& !empty($_POST['password_check'])){
    
    $username = $_POST['username'];

   if($_POST['password'] == $_POST['password_check']){

       if($user->exists($username)){

           $user->redirect('admin.php?page=add_user');
       }
       /*
         * hash all the passwords!
         *
         * */

       $password = $_POST['password'];
       $password = password_hash($password, PASSWORD_DEFAULT);
       
       $user->register($username, $password);

       $user->redirect('../public/admin.php?page=add_user');
       
   }



} else {
echo 'Gegevens onvolledig ingevuld';
}



}

?>
