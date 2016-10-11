<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 7-10-2016
 * Time: 10:17
 */
session_start();
require_once (realpath(__DIR__.'/config.php'));

spl_autoload_register( function($class){
 if(file_exists(__DIR__.'/classes/'.$class.'.php')){
     require_once (__DIR__.'/classes/'.$class.'.php');
 }
});

$user = new User();

