<?php

class Rptwo_read extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptwo_read_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptwo_read_m ;
    }

    public function index(){
        $this->load->view('rpt/rptwo_read') ;
    }

    public function init(){
        savesession($this, "ss_rptwo_", "") ;
        savesession($this, "ssrpt_wo_cUplFile", "") ;
    }
    

    public function saving(){
        $va 	    = $this->input->post() ;
        
        if($va['cOpsi'] == "reject") $va['cFakturReject'] = $this->bdb->getFakturRejectWO();
        //print_r($va);
        $cTitle = ($va['cOpsi'] == "reject") ? "Work Order Rejected" : "Work Order Finished"; 
        $saving = $this->bdb->saving($va) ;
        echo(' 
            bos.rptwo_read.loadModalReject("hide");
            bos.rptwo_read.showSwalInfo("'.$cTitle.'","","success");
            bos.rptwo_read.backToMasterWO() ;     
        ') ;
    }

}


?>