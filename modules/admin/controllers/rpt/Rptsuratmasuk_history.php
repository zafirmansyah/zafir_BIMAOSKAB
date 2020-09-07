<?php

class Rptsuratmasuk_history extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsuratmasuk_history_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptsuratmasuk_history_m ;
    }

    public function index(){
        $this->load->view('rpt/rptsuratmasuk_history') ;
    }

    public function init(){
        savesession($this, "ss_rptsuratmasuk_history", "") ;
        savesession($this, "ssrptsuratmasuk_history_cUplFile", "") ;
    }
}


?>