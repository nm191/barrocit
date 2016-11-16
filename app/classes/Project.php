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
    private $project_customer_name;
    private $project_customer_id;
    private $project_version;
    private $project_is_finished;
    private $project_name;
    private $project_is_onhold;


    public function __construct($project_id = 0)
    {
        $this->db = Database::getInstance();

        if($project_id && $this->projectExists($project_id)){
            $current_project = $this->getProjectByID($project_id);
            $this->project_id = $project_id;
            $this->project_name = $current_project->project_name;
            $this->project_priority = $current_project->project_priority;
            $this->project_deadline = $current_project->project_deadline;
            $this->project_start_date = $current_project->project_start_date;
            $this->project_description = $current_project->project_description;
            $this->project_version = $current_project->project_version;
            $this->project_is_finished = $current_project->project_is_finished;
            $this->project_customer_name = $current_project->customer_company_name;
            $this->project_customer_id = $current_project->customer_id;
            $this->project_is_onhold = $current_project->customer_is_onhold;

        }
    }

    public function updateProject(User $user, $posted_values = array()){
        unset($posted_values['type']);
        unset($posted_values['customer_name']);
        $project_id = $posted_values['project_id'];
        unset($posted_values['project_id']);

        $fields_ar = array_keys($posted_values);
        $sql_ar[] = "UPDATE `tbl_projects` SET";
        foreach($fields_ar as $field){
            $set_ar[] = $field.' = :'.$field;
        }
        $sql_ar[] = implode(', ', $set_ar);
        $sql_ar[] = 'WHERE project_id = :project_id';

        $stmt = $this->db->pdo->prepare(implode(' ', $sql_ar));

        $stmt->bindParam(':project_id', $project_id);
        $stmt->bindParam(':project_name', $posted_values['project_name']);
        $stmt->bindParam(':customer_id', $posted_values['customer_id']);
        $stmt->bindParam(':project_priority', $posted_values['project_priority']);
        $stmt->bindParam(':project_start_date', $posted_values['project_start_date']);
        $stmt->bindParam(':project_deadline', $posted_values['project_deadline']);
        $stmt->bindParam(':project_version', $posted_values['project_version']);
        $stmt->bindParam(':project_description', $posted_values['project_description']);

        $result = $stmt->execute();

        if($result){
            $message = 'Project has been editted!';
            $user->redirect('projects.php?page=edit_project&pid='.$project_id.'&success='.$message);
        }

    }

    public function deleteProject(User $user, $project_id){
        $sql = 'UPDATE `tbl_projects` SET project_is_active = 0 WHERE project_id = :project_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project_id', $project_id);
        $result = $stmt->execute();
        return $result;
    }

    public function finishProject(User $user, $project_id){
        $sql = 'UPDATE `tbl_projects` SET project_is_finished = 1 WHERE project_id = :project_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':project_id', $project_id);
        $result = $stmt->execute();
        return $result;
    }

    public function addProject(User $user, $posted_values = array()){
        unset($posted_values['type']);
        unset($posted_values['customer_name']);
        unset($posted_values['project_id']);

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
            $user->redirect('projects.php?success='.$message);
        }
    }

    public function getProjects(){
        $sql = 'SELECT * 
                FROM `tbl_projects` p
                INNER JOIN `tbl_customers` c
                ON p.customer_id = c.customer_id
                WHERE p.project_is_active = 1
                ORDER BY c.customer_is_onhold DESC';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProjectsTable(User $user){
        $projects = $this->getProjects();
        $table = '<table class="table table-hover table-responsive table-striped">';
        $table .= '<thead><tr><th>#</th><th>Priority</th><th>Project</th><th>Customer</th><th>Deadline</th><th>Version</th><th>Finished</th><th>Options</th></tr></thead>';
        foreach($projects as $project){

            $options_ar =$td_ar = array();

            $options_ar[] = '<a href="projects.php?page=view_project&pid='.$project->project_id.'" class="btn btn-small btn-primary btn-options" title="View project: '.$project->project_name.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
            if($user->hasAccess('development')){
                $options_ar[] = '<a href="../app/controllers/projectController.php?page=finish&pid='.$project->project_id.'" class="btn btn-small btn-success btn-options '.($project->project_is_finished ? " disabled" : "").'" title="Finished project: '.$project->project_name.'" '.($project->project_is_finished ? "disabled='disabled'" : "").' ><span class="glyphicon glyphicon-ok"></span></a>';
            }
            if($user->hasAccess('sales') || $user->hasAccess('development')){
                $options_ar[] = '<a href="projects.php?page=edit_project&pid='.$project->project_id.'" class="btn btn-small btn-warning btn-options" title="Edit project: '.$project->project_name.'"><span class="glyphicon glyphicon-edit"></span></a>';
            }
            if($user->hasAccess('sales') || $user->hasAccess('development')){
                $options_ar[] = '<a href="../app/controllers/projectController.php?page=delete&pid='.$project->project_id.'" class="btn btn-small btn-danger btn-options" id="deleteProject" title="Delete project: '.$project->project_name.'"><span class="glyphicon glyphicon-remove"></span></a>';
            }



            $td_ar[] = '<td>'.$project->project_id.'</td>';
            $td_ar[] = '<td>'.$project->project_priority.'</td>';
            $td_ar[] = '<td>'.$project->project_name.'</td>';
            $td_ar[] = '<td>'.$project->customer_company_name.'</td>';
            $td_ar[] = '<td>'.date('d-m-Y', strtotime($project->project_deadline)).'</td>';
            $td_ar[] = '<td>'.$project->project_version.'</td>';
            $td_ar[] = '<td>'.($project->project_is_finished ? 'Yes' : 'No').'</td>';
            $td_ar[] = '<td>'.implode('', $options_ar).'</td>';
            $table .= '<tr '.($project->customer_is_onhold ? 'class="on_hold"' : '').'>'.implode('', $td_ar).'</tr>';
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
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function searchProjectName($search_value){
        $sql = "SELECT * FROM `tbl_projects` WHERE project_name LIKE :search_value";
        $stmt = $this->db->pdo->prepare($sql);
        $search_value = '%'.$search_value.'%';
        $stmt->bindParam(':search_value', $search_value);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getOpenProjectsCount($customer_id = 0){
        $sql = 'SELECT COUNT(*) AS count FROM `tbl_projects` WHERE project_is_active = 1';
        if($customer_id){
            $sql .= ' AND customer_id = :customer_id';
        }
        $stmt = $this->db->pdo->prepare($sql);
        if($customer_id){
            $stmt->bindParam(':customer_id', $customer_id);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    public function getDeadlinesExpiredProjectsCount(){
        $sql = 'SELECT COUNT(*) AS count FROM `tbl_projects` WHERE project_is_active = 1 AND project_deadline < :date';
        $stmt = $this->db->pdo->prepare($sql);
        $date = date('Y-m-d');
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    public function getProjectId(){
        return $this->project_id;
    }
    public function getProjectName(){
        return $this->project_name;
    }

    public function getProjectPrio(){
        return $this->project_priority;
    }

    public function getProjectCustomerName(){
        return $this->project_customer_name;
    }

    public function getProjectCustomerId(){
        return $this->project_customer_id;
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

    public function getProjectIsOnHold(){
        return ($this->project_is_onhold ? 'Yes' : 'No');
    }

    public function getProjectData(){
        $return_ar = array();
        $return_ar['project_id'] = $this->getProjectId();
        $return_ar['project_name'] = $this->getProjectName();
        $return_ar['project_priority'] = $this->getProjectPrio();
        $return_ar['project_start_date'] = $this->getProjectStart();
        $return_ar['project_deadline'] = $this->getProjectDeadline();
        $return_ar['project_version'] = $this->getProjectVersion();
        $return_ar['project_description'] = $this->getProjectDescription();
        $return_ar['project_is_finished'] = $this->getProjectFinished();
        $return_ar['customer_name'] = $this->getProjectCustomerName();
        $return_ar['customer_id'] = $this->getProjectCustomerId();

        return $return_ar;
    }
}