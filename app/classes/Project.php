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
    private $project_id;
    private $project_priority;
    private $project_deadline;
    private $project_start_date;
    private $project_description;
    private $project_customer;
    private $project_version;
    private $project_is_finished;
    private $project_name;


    public function __construct($project_id = 0)
    {
        $this->db = Database::getInstance();

        if($project_id && $this->projectExists($project_id)){
            $current_project = $this->getProjectByID($project_id)[0];
            $this->project_id = $project_id;
            $this->project_name = $current_project->project_name;
            $this->project_priority = $current_project->project_priority;
            $this->project_deadline = $current_project->project_deadline;
            $this->project_start_date = $current_project->project_start_date;
            $this->project_description = $current_project->project_description;
            $this->project_version = $current_project->project_version;
            $this->project_is_finished = $current_project->project_is_finished;
            $this->project_customer = $current_project->customer_company_name;
        }
    }

    public function addProject(User $user, $posted_values = array()){
        unset($posted_values['type']);
        $fields_ar = array_keys($posted_values);
        $sql_ar[] = "INSERT INTO `tbl_projects`";
        $sql_ar[] = "(".implode(', ', $fields_ar).")";
        $sql_ar[] = "VALUES";
        $sql_ar[] = "(:".implode(', :', $fields_ar).")";

        $stmt = $this->db->pdo->prepare(implode(' ', $sql_ar));
//        foreach($posted_values as $field_name => $field_value){
//            $prepared_ar[':'.$field_name] = $field_value;
//            $stmt->bindParam(':'.$field_name, $field_value);
//        }
        $stmt->bindParam(':project_name', $posted_values['project_name']);
        $stmt->bindParam(':customer_id', $posted_values['customer_id']);
        $stmt->bindParam(':project_priority', $posted_values['project_priority']);
        $stmt->bindParam(':project_start_date', $posted_values['project_start_date']);
        $stmt->bindParam(':project_deadline', $posted_values['project_deadline']);
        $stmt->bindParam(':project_version', $posted_values['project_version']);
        $stmt->bindParam(':project_description', $posted_values['project_description']);

        $result = $stmt->execute();
//        var_dump($prepared_ar);
        if($result){
            $message = 'Project has been added!';
            $user->redirect('projects.php?page=add_project&success='.$message);
        }
    }

    public function getProjects(){
        $sql = 'SELECT * 
                FROM `tbl_projects` p
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                ORDER BY p.project_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProjectsTable(){
        $projects = $this->getProjects();
        $table = '<table class="table table-hover table-responsive table-striped">';
        $table .= '<thead><tr><th>#</th><th>Priority</th><th>Project</th><th>Customer</th><th>Deadline</th><th>Version</th><th>Finished</th><th>Options</th></tr></thead>';
        foreach($projects as $project){

            $options_ar =$td_ar = array();

            $options_ar[] = '<a href="projects.php?page=view_project&pid='.$project->project_id.'" class="btn btn-small btn-primary btn-options" title="View project: '.$project->project_name.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
            $options_ar[] = '<a href="#" class="btn btn-small btn-warning btn-options"><span class="glyphicon glyphicon-edit"></span></a>';
            $options_ar[] = '<a href="#" class="btn btn-small btn-danger btn-options"><span class="glyphicon glyphicon-remove"></span></a>';

            $td_ar[] = '<td>'.$project->project_id.'</td>';
            $td_ar[] = '<td>'.$project->project_priority.'</td>';
            $td_ar[] = '<td>'.$project->project_name.'</td>';
            $td_ar[] = '<td>'.$project->customer_company_name.'</td>';
            $td_ar[] = '<td>'.$project->project_deadline.'</td>';
            $td_ar[] = '<td>'.$project->project_version.'</td>';
            $td_ar[] = '<td>'.$project->project_is_finished.'</td>';
            $td_ar[] = '<td>'.implode('', $options_ar).'</td>';
            $table .= '<tr>'.implode('', $td_ar).'</tr>';
        }
        $table .= '</table>';
        return $table;
    }

    public function projectExists($project_id){
        $sql = "SELECT COUNT(project_id) as count FROM tbl_projects WHERE project_id = :project_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project_id', $project_id);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result->count;
    }

    public function getProjectByID($project_id){
        $sql = 'SELECT * 
                FROM `tbl_projects` p
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                WHERE p.project_id = :project_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project_id', $project_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProjectName(){
        return $this->project_name;
    }

    public function getProjectPrio(){
        return $this->project_priority;
    }

    public function getProjectCustomer(){
        return $this->project_customer;
    }

    public function getProjectStart(){
        return $this->project_start_date;
    }

    public function getProjectDeadline(){
        return $this->project_deadline;
    }

    public function getProjectVersion(){
        return $this->project_version;
    }

    public function getProjectDescription(){
        return $this->project_description;
    }

    public function getProjectFinished(){
        return ($this->project_is_finished ? 'Yes' : 'No');
    }
}