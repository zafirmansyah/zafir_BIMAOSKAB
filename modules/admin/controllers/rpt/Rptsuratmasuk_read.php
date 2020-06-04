<?php

class Rptsuratmasuk_read extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsuratmasuk_read_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptsuratmasuk_read_m ;
    }

    public function index(){
        $this->load->view('rpt/rptsuratmasuk_read') ;
    }

    



}


?>