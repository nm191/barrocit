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
    private $user_id;
    public $username;
    private $password;
    public $isLoggedIn = false; //camel-case: eerste woord kleine letter, de volgende woorden hoofdletter

    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();
        if($uid){
            $sql = 'SELECT * FROM tbl_users WHERE `user_id` = :uid';
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            $result = $stmt->fetchObject();
            if($result){
                $this->isLoggedIn = true;
                $this->username = $result->username;
                $this->user_id = $result->user_id;
            }

        }
    }

    public function login($username, $password){
        $sql = 'SELECT * FROM tbl_users WHERE `username` = :username';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetchObject();

        if(!password_verify($password, $result->password)){
            $message = 'Username or password is incorrect!';
            $this->redirect('index.php?error='.$message);
            exit();
        }

        $_SESSION['uid'] = $result->user_id;
        $_SESSION['username'] = $result->username;
        $_SESSION['user_level_id'] = $result->user_level_id;

        $this->isLoggedIn = true;
        $this->username = $result->username;

        $this->redirect('home.php');    
        return;
    }

    public function register($username, $password, $user_level){

        $sql = "INSERT INTO `tbl_users`
                (username, password, user_level_id) 
                VALUES(:username, :password, :user_level)";

        /* Paramatised queries*/
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_level', $user_level);
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
        session_destroy();
        $this->redirect('index.php');
    }

    public function redirect($path){
        header('location: ' . BASE_URL . '/public/' . $path);
    }

    public function hasAccess($user_right){
        $admin = new Admin();
        $user_right = trim(strtolower($user_right));

        //get section id
        $section = $admin->getUserRightId($user_right);
        
        //check if user has access.
        if(!$admin->userHasAccess($this->user_id, $section->user_right_id)){
         return false;
        }
        return true;
    }

    public function getUserID(){ return $this->user_id; }

}
