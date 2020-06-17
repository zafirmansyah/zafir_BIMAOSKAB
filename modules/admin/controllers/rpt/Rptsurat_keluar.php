<?php

class Rptsurat_keluar extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsurat_keluar_m') ;
        $this->load->helper('bdate') ;
        $this->load->helper('bsite') ;

        $this->bdb = $this->rptsurat_keluar_m ;
    }

    public function index(){
        $this->load->view('rpt/rptsurat_keluar') ;
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
            $vaset['JenisSurat']    = $this->bdb->getval("Keterangan", "Kode = '{$dbr['JenisSurat']}'","jenis_surat") ;
            $vaset['Unit']          = $this->bdb->getval("KodeRubrik", "Kode = '{$dbr['Unit']}'","golongan_unit") ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdCheckNomorSurat']       = '<button type="button" onClick="bos.rptsurat_keluar.cmdCheckNomorSurat(\''.$dbr['NoSurat'].'\')"
                                                    class="btn btn-info btn-grid">Show Nomor Surat</button>' ;
            $vaset['cmdCheckNomorSurat']	   = html_entity_decode($vaset['cmdCheckNomorSurat']) ;
            
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

    public function seekUnit()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekUnit($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }
}

?>