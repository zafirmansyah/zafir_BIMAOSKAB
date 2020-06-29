<?php

class Rptm02_prinsip extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptm02_prinsip_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->rptm02_prinsip_m ;
    }

    public function index(){
        $this->load->view('rpt/rptm02_prinsip') ;
    }

    public function init()
    {
        savesession($this, "ss_ID_M02PRINSIP_","") ;
        savesession($this, "ss_PERIHAL_M02PRINSIP_","") ;
        savesession($this, "ss_DARI_M02PRINSIP_","") ;
        savesession($this, "ss_DATETIME_M02PRINSIP_","") ;
        savesession($this, "ss_NOSURAT_M02PRINSIP_","") ;
        savesession($this, "ss_TANGGAL_M02PRINSIP_","");
        savesession($this, "ss_KODEDISPO_M02PRINSIP_","");
        savesession($this, "ss_DETAIL_M02PRINSIP_","");
    }

    public function loadgrid(){
        $va             = json_decode($this->input->post('request'), true) ;
        $vare           = array() ;
        $vdb            = $this->bdb->loadgrid($va) ;
        $dbd            = $vdb['db'] ;
        $lView          = true ;
        $cKodeKaryawan  = getsession($this,"KodeKaryawan");
        while( $dbr = $this->bdb->getrow($dbd) ){
            
            if($dbr['StatusMunculDisposisi'] == '0') {
                $lView = false ;
                if($cKodeKaryawan == $dbr['Pendisposisi']){
                    $lView = true ;
                }
            }

            if($lView){
                $vaset                      = $dbr ; 
                $vaset['Tgl']               = date_2d($dbr['Tgl']) ;
                $vaset['Dari']              = $this->bdb->getval("fullname","KodeKaryawan = '{$dbr['Pendisposisi']}'","sys_username") ;
                $vaset['cmdDetail']          = '<button type="button" onClick="bos.rptm02_prinsip.cmdDetail(\''.$dbr['FakturDokumen'].'\')"
                                                class="btn btn-info btn-grid">Open</button>' ;
                $vaset['cmdDetail']	        = html_entity_decode($vaset['cmdDetail']) ;
                $vaset['cmdTimeline']          = '<button type="button" onClick="bos.rptm02_prinsip.cmdTimeline(\''.$dbr['FakturDokumen'].'\')"
                                                class="btn btn-success btn-grid">Timeline</button>' ;
                $vaset['cmdTimeline']	        = html_entity_decode($vaset['cmdTimeline']) ;
                $vare[]		                = $vaset ;
            }
        }
        $vare 	= array("records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function setSessionIDSurat()
    {
        $cFaktur        = $this->input->post('cFaktur');
        $dbData         = $this->bdb->getDetailSuratMasuk($cFaktur);
        $vaFileList     = $this->getfilelist($cFaktur);
        $vaSess         = array() ;
        if($dbRow = $this->bdb->getrow($dbData)){        
            $vaSess['ss_ID_M02PRINSIP_']            = $cFaktur ;
            $vaSess['ss_KODEDISPO_M02PRINSIP_']     = $dbRow['KodeDisposisi'];
            $vaSess['ss_PERIHAL_M02PRINSIP_']       = $dbRow['Perihal'] ;
            $vaSess['ss_DARI_M02PRINSIP_']          = $dbRow['UserName'] ;
            $vaSess['ss_NOSURAT_M02PRINSIP_']       = $dbRow['NoSurat'] ;
            $vaSess['ss_TANGGAL_M02PRINSIP_']       = $dbRow['Tgl'];
            $vaSess['ss_DETAIL_M02PRINSIP_']        = $dbRow['Deskripsi'];
            $vaSess['ss_FILEITEM_M02PRINSIP_']      = $vaFileList;
            $vaSess['ss_DATETIME_M02PRINSIP_']      = $dbRow['DateTime'] ;
            foreach ($vaSess as $key => $value) {
				savesession($this, $key, $value) ;
			}
        }
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