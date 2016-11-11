<?php

/**
 * Created by PhpStorm.
 * User: aXed
 * Date: 13-10-2016
 * Time: 10:17
 */
class Modals
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    private function getModal($content, $modal_name, $modal_title){
        $modal = '<div id="'.$modal_name.'" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">'.$modal_title.'</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="search form-group"><input type="text" name="searchBox" id="searchBox'.$modal_name.'" placeholder="Search" class="form-control"></div>
                                    <div id="searchResults'.$modal_name.'">'.$content.'</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>';

        return $modal;
    }

    public function getCustomersModal(Customer $customer, $modal_name, $modal_title){
        $customers_ar = $customer->getAlldata();
        $table = '<table class="table">';
        $table .= '<thead><tr><th>Select</th><th>Customer</th></tr>';
        foreach($customers_ar as $customer){
            if(!$customer['customer_credit_worthy'] || $customer['customer_is_prospect'] || !$customer['customer_is_active'] || $customer['customer_is_onhold']){
                continue;
            }
           $table .= '<tr><td><input data-customer_name="'.$customer['customer_company_name'].'" type="radio" name="customer" id="customer" value="'.$customer['customer_id'].'"></td><td>'.$customer['customer_company_name'].'</td></tr>';
        }
        $table .= '</table>';

        return $this->getModal($table, $modal_name, $modal_title);
    }

    public function getProjectsModal(Project $project, $modal_name, $modal_title){
        $project_ar = $project->getProjects();
        $table = '<table class="table">';
        $table .= '<thead><tr><th>Select</th><th>Project</th></tr>';
        foreach($project_ar as $project){
            if(!$project->project_is_active){
                continue;
            }
            $table .= '<tr><td><input data-project_name="'.$project->project_name.'" type="radio" name="project" id="project" value="'.$project->project_id.'"></td><td>'.$project->project_name.'</td></tr>';
        }
        $table .= '</table>';

        return $this->getModal($table, $modal_name, $modal_title);
    }


}