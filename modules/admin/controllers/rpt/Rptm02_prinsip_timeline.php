<?php

class Rptm02_prinsip_timeline extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptm02_prinsip_timeline_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptm02_prinsip_timeline_m ;
    }

    public function index(){
        $this->load->view('rpt/rptm02_prinsip_timeline') ;
    }

    public function init(){
        savesession($this, "ss_m02_prinsip_", "") ;
        savesession($this, "sstcm02_prinsip_timeline_cUplFile", "") ;
    }
}


?>