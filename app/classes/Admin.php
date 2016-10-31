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
                ON users.user_level_id = ul.user_level_id
                ORDER BY users.user_id';
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

    private function getUserRights(){
        $sql = 'SELECT * FROM `tbl_user_rights`';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    private function getUserToUserRights($section){
        $sql = 'SELECT * FROM `tbl_user_to_user_rights` WHERE user_right_id = :user_right_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':user_right_id', $section);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getUserRightsTable(){
        $user_rights_ar = self::getUserRights();
        $table = '<table class="table table-responsive table-hover table-striped">';
        $table .= '<thead><tr><th>User Right</th></tr>';
        foreach($user_rights_ar as $user_right){
            $table .= '<tr><td><a href="admin.php?page=user_rights&section='.$user_right->user_right_id.'">'.$user_right->user_right_description.'</a> </td></tr>';
        }
        $table .= '</table>';

        return $table;
    }

    public function getUserRightsFormTable($section){
        if(!$section){
            return false;
        }
        $users_ar = $this->getAllUsers();
        $user_rights_ar = $this->getUserToUserRights($section);
        $input_ar = array();
        foreach($users_ar as $user){
            if(!$user_rights_ar){
                $input_ar[] = '<div class="checkbox"><label><input type="checkbox" name="user_id_'.$user->user_id.'" value="'.$user->user_id.'">'.$user->username.'</label></div>';
                continue;
            }
            foreach($user_rights_ar as $user_right){
                if($user->user_id != $user_right->user_id){
                    $input_ar[] = '<div class="checkbox"><label><input type="checkbox" name="user_id_'.$user->user_id.'" value="'.$user->user_id.'">'.$user->username.'</label></div>';
                }else {
                    $input_ar[] = '<div class="checkbox"><label><input type="checkbox" name="user_id_' . $user->user_id . '" value="' . $user->user_id . '" checked>' . $user->username . '</label></div>';
                }
            }
        }

        return implode('', $input_ar);

    }
}