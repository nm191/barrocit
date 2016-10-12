<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 12-10-2016
 * Time: 11:39
 */
class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    private function getAllUsers(){
        $sql = 'SELECT * 
                FROM `tbl_users` users
                LEFT JOIN `tbl_user_levels` ul
                ON users.user_level_id = ul.user_level_id';

        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getUsersTable(){
        $users_ar = $this->getAllUsers();
        if(empty($users_ar)) {
            return '<h2>No Users Found</h2>';
        }
        $table = '<table class="table table-striped table-responsive table-hover">';
        $table .= '<thead><tr><th>#</th><th>User</th><th>User Level</th><th>Active?</th></tr></thead>';
        $table .= '<tbody>';
        foreach($users_ar as $user){
            $table .= '<tr><td>'.$user->user_id.'</td><td>'.$user->username.'</td><td>'.$user->user_level_description.'</td><td>'.($user->user_is_active ? 'Yes' : 'No').'</td></tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }

    public function getUserLevelOptions(){
        $sql = 'SELECT user_level_id as id,user_level_description as description FROM `tbl_user_levels`';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result_ar = $stmt->fetchAll(PDO::FETCH_OBJ);
        $options = '';
        foreach($result_ar as $user_level){
            $options .= '<option name="'.$user_level->description.'" value="'.$user_level->id.'">'.$user_level->description.'</option>';
        }
        return $options;
    }
}