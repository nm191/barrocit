<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 7-10-2016
 * Time: 10:58
 */
class User
{
    private $db;
    private $username;
    private $password;
    private $isLoggedIn; //camel-case: eerste woord kleine letter, de volgende woorden hoofdletter

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function login($info){

//        $stmt = $this->db->pdo->query("SELECT * FROM `users` WHERE id = $id")
//        $user = $stmt->fetch();

        $_SESSION['uid'] = $info['uid'];
        $_SESSION['username'] = $info['username'];
        $_SESSION['role'] = $info['role'];

        header('location: ' . BASE_URL . '/app/router.php');
    }

    public function register($username, $password){

        $sql = "INSERT INTO `tbl_users`
                (username, password) 
                VALUES(:username, :password)";

        /* Paramatised queries*/

        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

    }

    public function exists($username){
        $sql = "SELECT COUNT(user_id) as count FROM tbl_users WHERE username = :username";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result->count;

    }

    public function logout(){
        echo 'Dit is de logout method';
        session_destroy();
    }

    public function redirect($path){
        header('location: ' . BASE_URL . '/public/' . $path);
    }

}
