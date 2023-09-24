<?php

class Rpt_logactivity extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rpt_logactivity_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->rpt_logactivity_m ;
    }

    public function index(){
        $this->load->view('rpt/rpt_logactivity') ;
    }

    public function init()
    {
        savesession($this, "ss_ID_SuratKeluar_","") ;
        savesession($this, "ss_PERIHAL_SuratKeluar_","") ;
        savesession($this, "ss_DARI_SuratKeluar_","") ;
        savesession($this, "ss_DATETIME_SuratKeluar_","") ;
        savesession($this, "ss_NOSURAT_SuratKeluar_","") ;
        savesession($this, "ss_TANGGAL_SuratKeluar_","");
        
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['fullname']    = $this->bdb->getval("fullname", "username = '{$dbr['username']}'","sys_username") ;
            // $vaset['cmdCheckNomorSurat']       = '<button type="button" onClick="bos.rpt_logactivity.cmdCheckNomorSurat(\''.$dbr['NoSurat'].'\')"
            //                                         class="btn btn-info btn-grid">Show Nomor Surat</button>' ;
            // $vaset['cmdCheckNomorSurat']	   = html_entity_decode($vaset['cmdCheckNomorSurat']) ;
            
            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDSurat()
    {
        $cKode      = $this->input->post('cKode');
        $dbData     = $this->bdb->getDetailSuratKeluar($cKode);
        $vaFileList = $this->getfilelist($cKode);
        $vaSess     = array() ;
        if($dbRow = $this->bdb->getrow($dbData)){        
            $vaSess['ss_ID_SuratKeluar_']            = $cKode ;
            $vaSess['ss_PERIHAL_SuratKeluar_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_SuratKeluar_']          = $dbRow['Dari'] ;
            $vaSess['ss_DATETIME_SuratKeluar_']      = $dbRow['DateTime'] ;
            $vaSess['ss_NOSURAT_SuratKeluar_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_SuratKeluar_']       = $dbRow['Tgl'];
            $vaSess['ss_FILEITEM_SuratKeluar_']      = $vaFileList;
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
    }

    public function getfilelist($cKode){
        $dbData = $this->bdb->getFileListSuratKeluar($cKode);
        $i = 0;
        $vaData = array();
        while($dbRow = $this->bdb->getrow($dbData)){
            $vaData[$i]=$dbRow;
            $i++;
        }        
        return $vaData;
    }

    public function seekUserList()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekUserList($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['username'], "text"=>$dbr['username'] ." - ".$dbr['fullname']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }
}

?>