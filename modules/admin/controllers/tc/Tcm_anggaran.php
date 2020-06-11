<?php

class Tcm_anggaran extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcm_anggaran_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcm_anggaran_m ;
    }

    public function index(){
        $this->load->view('tc/tcm_anggaran') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                  = $dbr ;
            $cKodeUnit              = $this->bdb->getval("Unit","username = '{$dbr['UserName']}'","sys_username") ;
            $vaset['Unit']          = $this->bdb->getval("KodeRubrik","Kode = '{$cKodeUnit}'","golongan_unit") ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcsurat_masuk.cmdEdit(\''.$dbr['Faktur'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcsurat_masuk.cmdDelete(\''.$dbr['Faktur'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	   = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	= html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function SeekSifatSurat()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekSifatSurat($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

    public function validSaving()
    {
        $va     = $this->input->post();
        $vaGrid = json_decode($va['dataDetailAnggaran']);
        $lValid = true ;
        if(empty($vaGrid)){
            $lValid = false ;
            echo('
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Valid" ,
                    text : "Data Detail Anggaran Kosong"
                });   
            ');
        }

        if($lValid){
            $this->saveData($va) ;
        }   
    }

    public function saveData($va)
    {
        $cSifatSurat = $va['optSifatSurat'];

        $cFaktur  = $va['cFaktur'] ;
        if($cFaktur == "" || empty(trim($cFaktur))){
            $cFaktur = $this->bdb->getKodeSurat();
        }
        
        $cNoSurat  = $va['cNoSurat'] ;
        if($cNoSurat == "" || empty(trim($cNoSurat))){
            $cNoSurat = $this->bdb->getNomorSurat($cSifatSurat);
        }

        $va['cFaktur']  = $cFaktur ;
        $va['cNoSurat'] = $cNoSurat ;
        $save           = $this->bdb->saveData($va) ;
        if($save){
            echo('
                bos.tcm_anggaran.initForm() ;
                bos.tcm_anggaran.initTab1() ;
                Swal.fire({
                    icon: "success",
                    title: "'.$va['cNoSurat'].'",
                    html: "Nomor Surat <b> M.02 Penarikan Anggaran </b> Sebagai Berikut"
                });   
            ');
        }
    }
}


?>