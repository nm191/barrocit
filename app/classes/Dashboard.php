<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 1-11-2016
 * Time: 11:31
 */
class Dashboard
{
    private $db;
    private $project;
    private $invoice;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->project = new Project();
        $this->invoice = new Invoice();
    }

    public function getDashboardTable(User $user){
        $open_projects = $this->project->getOpenProjectsCount();
        $deadlines_expired = $this->project->getDeadlinesExpiredProjectsCount();
        $open_invoices = $this->invoice->getOpenInvoicesCount();
        $open_invoices_total = $this->invoice->getOpenInvoicesSum();

        $th_ar[] = '<th>Open projects</th>';
        $th_ar[] = '<th>Deadlines expired</th>';
        if($user->hasAccess('finance')){
            $th_ar[] = '<th>Open invoices</th>';
            $th_ar[] = '<th>Open invoices total</th>';
        }


        $td_ar[] = '<td>'.$open_projects.'</td>';
        $td_ar[] = '<td>'.$deadlines_expired.'</td>';
        if($user->hasAccess('finance')){
            $td_ar[] = '<td>'.$open_invoices.'</td>';
            $td_ar[] = '<td>&euro; '.$open_invoices_total.'</td>';
        }
        
        $return_ar[] = '<table class="table table-responsive table-bordered table-dashboard">';
        $return_ar[] = '<thead><tr>'.implode('', $th_ar).'</tr>';
        $return_ar[] = '<tr>'.implode('', $td_ar).'</tr>';
        $return_ar[] = '</table>';

        return implode('', $return_ar);
    }
}