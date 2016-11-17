<?php

/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 12-10-2016
 * Time: 10:53
 */
class Customer
{

    private $db;
    private $general;
    private $addresses;
    private $contact;
    private $financial;
    private $customer_data;


    public function __construct($uid = 0)
    {
        $this->db = Database::getInstance();

        if($uid){
            $this->customer_data = $this->getCustomerById($uid);
            $this->setCustomerFilledStatusses($this->customer_data);
        }
    }

    public function getAlldata()
    {
        $sql = "SELECT * FROM tbl_customers WHERE customer_is_active = 1 ORDER BY customer_is_onhold DESC";
        $result = $this->db->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($customer_id)
    {
        $sql = "UPDATE `tbl_customers`  
                SET customer_is_active = 0
                WHERE customer_id = :customer_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $result = $stmt->execute();
        return $result;
        
    }
    
    public function getCustomerById($id){
        $sql = "SELECT tbl_customers.*, COUNT(tbl_projects.project_id) AS open_projects  FROM tbl_customers 
                LEFT JOIN tbl_projects 
                ON tbl_customers.customer_id = tbl_projects.customer_id 
                AND tbl_projects.project_is_finished = 0 
                AND tbl_projects.project_is_active = 1
                WHERE tbl_customers.customer_id = :id 
                GROUP BY tbl_customers.customer_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLatest() {
        $sql = "SELECT * FROM `tbl_customers` ORDER BY customer_id DESC LIMIT 1";
        $result = $this->db->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addGeneralData($customer_company_name, $customer_sales_agent, $customer_is_prospect, $customer_maintenance_contract){

        $sql = "INSERT INTO `tbl_customers`(customer_company_name, customer_sales_agent, customer_is_prospect, customer_maintenance_contract) 
                VALUES (:customer_company_name, :customer_sales_agent, :customer_is_prospect, :customer_maintenance_contract)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_company_name', $customer_company_name);
        $stmt->bindParam(':customer_sales_agent', $customer_sales_agent);
        $stmt->bindParam(':customer_is_prospect', $customer_is_prospect);
        $stmt->bindParam(':customer_maintenance_contract', $customer_maintenance_contract);
        $result = $stmt->execute();
        $this->general = true;
        return $result;
        
    }
    
    public function updateGeneralData($cc_name, $cs_agent, $prospect, $contract, $id){
        $sql = "UPDATE `tbl_customers` 
                SET customer_company_name = :cc_name, customer_sales_agent = :cs_agent, customer_is_prospect = :prospect, customer_maintenance_contract = :contract
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':cc_name', $cc_name);
        $stmt->bindParam(':cs_agent', $cs_agent);
        $stmt->bindParam(':prospect', $prospect);
        $stmt->bindParam(':contract', $contract);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        return $result;
    }


    public function addAddress($customer_address, $customer_zipcode, $customer_city, $customer_sec_address, $customer_sec_zipcode, $customer_sec_city, $id) {

        $sql = "UPDATE `tbl_customers` SET customer_address = :customer_address, customer_zipcode = :customer_zipcode, customer_city = :customer_city, customer_sec_address = :customer_sec_address, 
                customer_sec_zipcode = :customer_sec_zipcode, customer_sec_city = :customer_sec_city WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_address', $customer_address);
        $stmt->bindParam(':customer_zipcode', $customer_zipcode);
        $stmt->bindParam(':customer_city', $customer_city);
        $stmt->bindParam(':customer_sec_address', $customer_sec_address);
        $stmt->bindParam(':customer_sec_zipcode', $customer_sec_zipcode);
        $stmt->bindParam(':customer_sec_city', $customer_sec_city);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        $this->addresses = true;
        return $result;

    }

    public function addContactPerson($initials, $firstname, $surname, $email, $phone, $sec_phone, $fax, $id){
        $sql = "UPDATE `tbl_customers` 
                SET customer_contact_initials = :cc_initials, customer_contact_firstname = :cc_firstname, customer_contact_surname = :cc_surname, customer_contact_email = :cc_email, 
                customer_contact_phone = :cc_phone, customer_contact_sec_phone = :cc_sec_phone, customer_fax = :cc_fax
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':cc_initials', $initials);
        $stmt->bindParam(':cc_firstname', $firstname);
        $stmt->bindParam(':cc_surname', $surname);
        $stmt->bindParam(':cc_email', $email);
        $stmt->bindParam(':cc_phone', $phone);
        $stmt->bindParam(':cc_sec_phone', $sec_phone);
        $stmt->bindParam(':cc_fax', $fax);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        $this->contact = true;
        return $result;

    }

    public function addFinancial($discount, $overdraft, $payterm, $bankaccount, $ledgeraccount, $revenue, $tax_id, $credit_worthy, $id){
        $sql = "UPDATE `tbl_customers`
                SET customer_discount = :c_discount, customer_overdraft = :c_overdraft, customer_pay_term = :c_p_term, 
                customer_bank_account = :c_bankaccount, customer_ledger_account = :c_ledgeraccount, 
                customer_revenue = :c_revenue, tax_code_id = :tax_id, customer_credit_worthy = :credit_worthy
                WHERE customer_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':c_discount', $discount);
        $stmt->bindParam(':c_overdraft', $overdraft);
        $stmt->bindParam(':c_p_term', $payterm);
        $stmt->bindParam(':c_bankaccount', $bankaccount);
        $stmt->bindParam(':c_ledgeraccount', $ledgeraccount);
        $stmt->bindParam(':c_revenue', $revenue);
        $stmt->bindParam(':tax_id', $tax_id);
        $stmt->bindParam(':credit_worthy', $credit_worthy);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        $this->financial = true;
        return $result;
    }

    public function getAllVisits(){
        $sql = "SELECT * FROM `tbl_visits`";
        $result = $this->db->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getVisitById($id){
        $sql = "SELECT * FROM tbl_visits 
                LEFT JOIN tbl_customers 
                ON  tbl_visits.customer_id = tbl_customers.customer_id
                WHERE tbl_visits.visit_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchCustomerName($search_value){
        $sql = "SELECT * FROM `tbl_customers` WHERE customer_company_name LIKE :search_value";
        $stmt = $this->db->pdo->prepare($sql);
        $search_value = '%'.$search_value.'%';
        $stmt->bindParam(':search_value', $search_value);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function setCustomerOnHold($customer_id){
        $sql = 'UPDATE `tbl_customers` SET customer_is_onhold = 1 WHERE customer_id = :customer_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $result = $stmt->execute();
        return $result;
    }

    public function getVisitTypeOptions($visitData){
        $sql = 'SELECT * FROM  `tbl_visit_types`';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($result as $visit_type){
            if($visitData && $visitData['visit_type_id'] == $visit_type->id){
                $return_ar[] = "<option value='$visit_type->id' selected>$visit_type->title</option>";
            }else {
                $return_ar[] = "<option value='$visit_type->id'>$visit_type->title</option>";
            }
        }

        return implode('', $return_ar);
    }

    public function addCustomerVisit($posted_values){
        $customer_id = $posted_values['customer_id'];
        $type_id = $posted_values['visitType'];
        $visit_text = $posted_values['visit_text'];
        $visit_date = $posted_values['visit_date'];
        $action_for = (isset($posted_values['actionFor']) ? $posted_values['actionFor'] : NULL);
        $action_date = (isset($posted_values['action_date']) ? $posted_values['action_date'] : NULL);
        $action_is_finished = (isset($posted_values['actionFinished']) ? 1 : 0);

        $sql = 'INSERT INTO `tbl_visits` (customer_id, visit_type_id, visit_date, visit_text, visit_action_date, visit_action_for, visit_action_is_finished) VALUES (:customer_id, :type_id, :visit_date, :visit_text, :visit_action_date, :visit_action_for, :action_finished)';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':type_id', $type_id);
        $stmt->bindParam(':visit_text', $visit_text);
        $stmt->bindParam(':visit_date', $visit_date);
        $stmt->bindParam(':visit_action_for', $action_for);
        $stmt->bindParam(':visit_action_date', $action_date);
        $stmt->bindParam(':action_finished', $action_is_finished);
        $result = $stmt->execute();
        return $result;
    }
    
    public function updateCustomerVisit($posted_values){
        $type_id = $posted_values['visitType'];
        $visit_text = $posted_values['visit_text'];
        $visit_date = $posted_values['visit_date'];
        $action_for = (isset($posted_values['actionFor']) ? $posted_values['actionFor'] : NULL);
        $action_date = (isset($posted_values['action_date']) ? $posted_values['action_date'] : NULL);
        $action_is_finished = (isset($posted_values['actionFinished']) ? 1 : 0);
        $visit_id = $posted_values['visit_id'];

        $sql = 'UPDATE `tbl_visits` SET visit_type_id = :type_id, visit_text = :visit_text, visit_date = :visit_date, visit_action_for = :action_for, visit_action_date = :action_date, visit_action_is_finished = :action_finished WHERE visit_id = :visit_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':type_id', $type_id);
        $stmt->bindParam(':visit_text', $visit_text);
        $stmt->bindParam(':visit_date', $visit_date);
        $stmt->bindParam(':action_for', $action_for);
        $stmt->bindParam(':action_date', $action_date);
        $stmt->bindParam(':visit_id', $visit_id);
        $stmt->bindParam(':action_finished', $action_is_finished);
        $result = $stmt->execute();
        return $result;
    }

    public function getCustomerIsFilled(){

        if( $this->addresses    &&
            $this->general      &&
            $this->financial    &&
            $this->contact){
            return true;
        }
        return false;
    }

    public function getTaxCodeOptions($customer_tax_code_id = 0){
        $sql = 'SELECT * FROM `tbl_tax_codes`';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $tax_codes_ar = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($tax_codes_ar);
        foreach($tax_codes_ar as $tax_code){
            $return_ar[] = '<option value="'.$tax_code->tax_code_id .'" '.($customer_tax_code_id == $tax_code->tax_code_id ? 'selected' : '').'>'.$tax_code->tax_code_description.'</option>';
        }

        return implode('', $return_ar);
    }

    public function getSoftHardwareById($shid){
        $sql = 'SELECT * FROM `tbl_customer_softhardwares` s LEFT JOIN `tbl_software_hardware_types` t ON s.softhard_type_id = t.soft_hard_type_id WHERE softhard_id = :shid';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':shid', $shid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    public function getSoftHardTypeOptions($softhard){
        $sql = 'SELECT * FROM `tbl_software_hardware_types`';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $types_ar = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($types_ar as $type){
            $return_ar[] = '<option value="'.$type->soft_hard_type_id.'" '.($type->soft_hard_type_id == $softhard->softhard_type_id ? 'selected' : '' ).'>'.$type->soft_hard_type_description.'</option>';
        }

        return implode('', $return_ar);
    }

    public function addSoftHardware($posted_values){
        if(!$posted_values){
            return false;
        }

        $sql = 'INSERT INTO `tbl_customer_softhardwares` (customer_id, softhard_type_id, softhard_name, softhard_desc, softhard_version) VALUES (:customer_id, :type_id, :shname, :shdesc, :shversion)';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $posted_values['customer_id']);
        $stmt->bindParam(':type_id', $posted_values['type']);
        $stmt->bindParam(':shname', $posted_values['shname']);
        $stmt->bindParam(':shdesc', $posted_values['shdesc']);
        $stmt->bindParam(':shversion', $posted_values['shversion']);
        $result = $stmt->execute();
       return $result;

    }

    public function updateSoftHardware($posted_values){
        $sql = 'UPDATE `tbl_customer_softhardwares` SET  softhard_type_id = :type_id, softhard_name = :shname, softhard_desc = :shdesc, softhard_version = :shversion WHERE softhard_id = :shid';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':type_id', $posted_values['type']);
        $stmt->bindParam(':shname', $posted_values['shname']);
        $stmt->bindParam(':shdesc', $posted_values['shdesc']);
        $stmt->bindParam(':shversion', $posted_values['shversion']);
        $stmt->bindParam(':shid', $posted_values['shid']);
        $result = $stmt->execute();
        return $result;
    }

    private function getSoftHardwares(){
        $sql = 'SELECT * FROM `tbl_customer_softhardwares` s LEFT JOIN `tbl_software_hardware_types` t ON s.softhard_type_id = t.soft_hard_type_id WHERE s.is_active = 1';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public function getSoftHardwaresTable(){
        $softhard_ar = $this->getSoftHardwares();
        $return_ar[] = '<table class="table table-reponsive table-striped table-hover">';
        $return_ar[] = '<thead><tr><th>ID</th><th>Type</th><th>Name</th><th>Description</th><th>Version</th><th>Options</th></tr></thead>';

        $tr_ar = array();
        foreach($softhard_ar as $sh){
            $options_ar = $td_ar = array();
            $options_ar[] = '<a href="customers.php?page=customer_soft_hard_form&shid='.$sh->softhard_id.'&customer_id='.$sh->customer_id.'" class="btn btn-small btn-warning btn-options" title="Edit '.$sh->soft_hard_type_description.': '.$sh->softhard_name.'"><span class="glyphicon glyphicon-edit"></span></a>';
            $options_ar[] = '<a href="../app/controllers/customerController.php?page=delete_sh&customer_id='.$sh->customer_id.'&shid='.$sh->softhard_id.'" class="btn btn-small btn-danger btn-options" id="deleteSoftHardware" title="Delete '.$sh->soft_hard_type_description.' : '.$sh->softhard_name.'"><span class="glyphicon glyphicon-remove"></span></a>';

            $td_ar[] = '<td>'.$sh->softhard_id.'</td>';
            $td_ar[] = '<td>'.$sh->soft_hard_type_description.'</td>';
            $td_ar[] = '<td>'.$sh->softhard_name.'</td>';
            $td_ar[] = '<td>'.$sh->softhard_desc.'</td>';
            $td_ar[] = '<td>'.$sh->softhard_version.'</td>';
            $td_ar[] = '<td>'.implode('', $options_ar).'</td>';
            $tr_ar[] = implode('', $td_ar);
        }
        $return_ar[] = implode('', $tr_ar);
        $return_ar[] = '</table>';

        return implode('', $return_ar);
    }

    public function deleteSoftHardware($shid){
        $sql = 'UPDATE `tbl_customer_softhardwares` SET is_active = 0';
        $stmt = $this->db->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    public function searchCustomers($search_value){
        $sql = 'SELECT * 
                FROM tbl_customers 
                WHERE customer_is_active = 1 
                AND (customer_company_name LIKE :search_value
                OR customer_address LIKE :search_value
                OR customer_contact_firstname LIKE :search_value
                OR customer_contact_surname LIKE :search_value
                OR customer_contact_email LIKE :search_value
                OR customer_sales_agent LIKE :search_value)
                ORDER BY customer_is_onhold DESC';
        $stmt = $this->db->pdo->prepare($sql);
        $search_value = '%'.$search_value.'%';
        $stmt->bindParam(':search_value', $search_value);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    private function setCustomerFilledStatusses($customer_data){
        $general_ar = array('customer_company_name', 'customer_sales_agent');
        $addresses_ar = array('customer_address', 'customer_zipcode', 'customer_city');
        $contact_ar = array('customer_contact_initials', 'customer_contact_firstname', 'customer_contact_surname', 'customer_contact_phone', 'customer_contact_email');
        $financial_ar = array('customer_overdraft', 'customer_pay_term', 'customer_bank_account', 'customer_ledger_account', 'customer_revenue');

        $missing_values = 0;

        //loop door de array om te checken of een van de velden empty is
        //general_data
        foreach($general_ar as $value){
            if(empty($customer_data[$value])){
                $missing_values++;
            }
        }

        if($missing_values == 0){
            $this->general = true;
        }


        //addresses data
        $missing_values = 0;
        foreach($addresses_ar as $value){
            if(empty($customer_data[$value])){
                $missing_values++;
            }
        }

        if($missing_values == 0){
            $this->addresses = true;
        }

        //contact data
        $missing_values = 0;
        foreach($contact_ar as $value){
            if(empty($customer_data[$value])){
                $missing_values++;
            }
        }

        if($missing_values == 0){
            $this->contact = true;
        }

        //financial_data
        $missing_values = 0;
        foreach($financial_ar as $value){
            if(empty($customer_data[$value])){
                $missing_values++;
            }
        }

        if($missing_values == 0){
            $this->financial = true;
        }

        return true;
    }
}