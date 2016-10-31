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
            var_dump($_POST);
            break;
    }

}