<?php

class Rptsuratmasuk extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsuratmasuk_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptsuratmasuk_m ;
    }

    public function index(){
        $this->load->view('rpt/rptsuratmasuk') ;
    }

    public function init()
    {
        savesession($this, "ss_ID_SuratMasuk_","") ;
        savesession($this, "ss_PERIHAL_SuratMasuk_","") ;
        savesession($this, "ss_DARI_SuratMasuk_","") ;
        savesession($this, "ss_DATETIME_SuratMasuk_","") ;
        savesession($this, "ss_NOSURAT_SuratMasuk_","") ;
        
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ; 
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdDetail']       = '<a onClick="bos.rptsuratmasuk.cmdDetail(\''.$dbr['Kode'].'\')">'.strtoupper($dbr['Perihal']).'</a>' ;
            $vaset['cmdDetail']	    = html_entity_decode($vaset['cmdDetail']) ;
            

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDSurat()
    {
        $cKode  = $this->input->post('cKode');
        $dbData = $this->bdb->getDetailSuratMasuk($cKode);
        $vaSess = array() ;
        if($dbRow = $this->bdb->getrow($dbData)){        
            $vaSess['ss_ID_SuratMasuk_']            = $cKode ;
            $vaSess['ss_PERIHAL_SuratMasuk_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_SuratMasuk_']          = $dbRow['Dari'] ;
            $vaSess['ss_DATETIME_SuratMasuk_']      = $dbRow['DateTime'] ;
            $vaSess['ss_NOSURAT_SuratMasuk_']       = $dbRow['NoSurat'] ;

            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
    }
}



?>