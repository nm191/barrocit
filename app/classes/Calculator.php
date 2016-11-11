<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4-11-2016
 * Time: 09:52
 */
class Calculator
{

    private $db;
    private $customer;
    private $invoice;
    private $admin;
    private $notification;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->customer = new Customer();
        $this->invoice = new Invoice();
        $this->admin = new Admin();
        $this->notification = new Notifications();

    }
    
    public function calcOverdraftLimits(){
        //get all active customers
        $customers_ar = $this->customer->getAlldata();

        //var_dump($customers_ar);
        
        foreach($customers_ar as $customer){
            if($customer['customer_is_onhold']){
                continue;
            }
            $overdraft_limit = $customer['customer_overdraft'];
            
            //get all unpaid invoices
            $invoices_ar = $this->invoice->getUnpaidInvoicesByCustomerID($customer['customer_id']);

            $invoices_total = 0;
            foreach($invoices_ar as $invoice){
                $invoices_total += $invoice->invoice_total;
            }

            if($invoices_total > $overdraft_limit) {
                //add notification
                $for_section_id = $this->admin->getUserRightId('development');
                $note_text = '\'' . $customer['customer_company_name'] . '\' have passed their overdraft limit and is put on hold.';
                $this->notification->addNotification($for_section_id->user_right_id, 14, $note_text); // 14 = system

                //set customer on hold
                $this->customer->setCustomerOnHold($customer['customer_id']);
            }
        }
        return true;
    }

}