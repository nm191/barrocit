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
                                    '.$content.'
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
           $table .= '<tr><td><input data-customer_name="'.$customer['customer_company_name'].'" type="radio" name="customer" id="customer" value="'.$customer['customer_id'].'"></td><td>'.$customer['customer_company_name'].'</td></tr>';
        }
        $table .= '</table>';

        return $this->getModal($table, $modal_name, $modal_title);
    }

}