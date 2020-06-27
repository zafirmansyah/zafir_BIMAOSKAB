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
    

    public function getData(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_rptwo_", $cKode) ;
            echo('
                with(bos.rptwo_read.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSuratDari").val("'.$data['Dari'].'") ;
                    $("#cPerihal").val("'.$data['Perihal'].'") ;
                    $("#cNomorSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#dTglSurat").val("'.date_2d($data['TglSurat']).'") ;
                    $("#cLastPath").val("'.$data['Path'].'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    bos.rptwo_read.gridDisposisi_reload() ;
                }
            ') ;
        }
    }

}


?>