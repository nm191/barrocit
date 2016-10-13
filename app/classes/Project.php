<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 13-10-2016
 * Time: 09:21
 */
class Project
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function addProject($posted_values = array()){
        unset($posted_values['type']);
        $fields_ar = array_keys($posted_values);
        $sql_ar[] = "INSERT INTO `tbl_projects`";
        $sql_ar[] = "(".implode(', ', $fields_ar).")";
        $sql_ar[] = "VALUES";
        $sql_ar[] = "(:".implode(', :', $fields_ar).")";

        $stmt = $this->db->pdo->prepare(implode(' ', $sql_ar));
        foreach($posted_values as $field_name => $field_value){
            $stmt->bindParam(':'.$field_name, $field_value);
        }
        $result = $stmt->execute();
        var_dump($result);

    }
}