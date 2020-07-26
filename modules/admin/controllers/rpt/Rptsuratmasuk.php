<?php

class Rptsuratmasuk extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsuratmasuk_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

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
        savesession($this, "ss_TANGGAL_SuratMasuk_","");
        
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ; 
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['TglDisposisi']  = date_2d($dbr['TglDisposisi']);
            $vaset['cmdDetail']       = '<a onClick="bos.rptsuratmasuk.cmdDetail(\''.$dbr['Kode'].'\')">'.strtoupper($dbr['Perihal']).'</a>' ;
            $vaset['cmdDetail']	    = html_entity_decode($vaset['cmdDetail']) ;
            $vaset['cmdHistory']    = "";
            // if(getsession($this,"Jabatan") <= "002"){
                $vaset['cmdHistory']    = '<button class="btn btn-info btn-grid" onClick="bos.rptsuratmasuk.cmdHistory(\''.$dbr['Kode'].'\')" title="Show History"> <i class="fa fa-history"></i> History</button>' ;
                $vaset['cmdHistory']     = html_entity_decode($vaset['cmdHistory']) ;
            // }
            $vare[]		= $vaset ;
        }
        $vare 	= array("records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDSurat()
    {
        $cKode      = $this->input->post('cKode');
        $cTerdisposisi = getsession($this,"KodeKaryawan");
        $dbData     = $this->bdb->getDetailSuratMasuk($cKode);
        $vaFileList = $this->getfilelist($cKode);
        $vaSess     = array() ;
        if($dbRow = $this->bdb->getrow($dbData)){        
            $vaSess['ss_ID_SuratMasuk_']            = $cKode ;
            $vaSess['ss_PERIHAL_SuratMasuk_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_SuratMasuk_']          = $dbRow['Dari'] ;
            $vaSess['ss_DATETIME_SuratMasuk_']      = $dbRow['DateTime'] ;
            $vaSess['ss_NOSURAT_SuratMasuk_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_SuratMasuk_']       = $dbRow['Tgl'];
            $vaSess['ss_DESKRIPSI_SuratMasuk_']     = $this->bdb->getDeskripsiDisposisiSurat($cKode,$cTerdisposisi);
            $vaSess['ss_FILEITEM_SuratMasuk_']      = $vaFileList;
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
    }
    
    public function setSessionIDHistory()
    {
        $cKode      = $this->input->post('cKode');
        $dbData     = $this->bdb->getDetailSuratMasuk($cKode);
        $vaFileList = $this->getfilelist($cKode);
        $vaSess     = array() ;
        if($dbRow = $this->bdb->getrow($dbData)){        
            $vaSess['ss_ID_SuratMasuk_']            = $cKode ;
            $vaSess['ss_PERIHAL_SuratMasuk_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_SuratMasuk_']          = $dbRow['Dari'] ;
            $vaSess['ss_DATETIME_SuratMasuk_']      = $dbRow['DateTime'] ;
            $vaSess['ss_NOSURAT_SuratMasuk_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_SuratMasuk_']       = $dbRow['Tgl'];
            $vaSess['ss_FILEITEM_SuratMasuk_']      = $vaFileList;
            $vaSess['ss_HISTORY_SuratMasuk_']       = $this->getHistorySuratMasuk($cKode);
            ///print_r($vaSess);
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
    }

    public function getHistorySuratMasuk($cKode)
    {
        $dbData = $this->bdb->getHistorySuratMasuk($cKode);
        $i = 0;
        $vaData = array();
        while($dbRow = $this->bdb->getrow($dbData)){
            $dbRow['Terdisposisi'] = $this->bdb->getUserNameByKodeKaryawan($dbRow['Terdisposisi']);
            $dbRow['Pendisposisi'] = $this->bdb->getUserNameByKodeKaryawan($dbRow['Pendisposisi']);
            $dbRow['Deskripsi']    = $dbRow['Deskripsi'] == "" ? "Tanpa Deskripsi" : $dbRow['Deskripsi']; 
            $vaData[$i]=$dbRow;
            $i++;
        }        
        return $vaData;
    }

    public function getfilelist($cKode){
        $dbData = $this->bdb->getFileListSuratMasuk($cKode);
        $i = 0;
        $vaData = array();
        while($dbRow = $this->bdb->getrow($dbData)){
            $vaData[$i]=$dbRow;
            $i++;
        }        
        return $vaData;
    }
}

?>