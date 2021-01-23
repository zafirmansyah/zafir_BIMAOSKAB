<?php 

/**
 * 
 */
class Rptpsbi_realisasi extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptpsbi_realisasi_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptpsbi_realisasi_m ;
    }

    public function index(){
        $this->load->view('rpt/rptpsbi_realisasi') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                  = $dbr ;
            $cGolonganPSBI          = $this->bdb->getval("Keterangan","Kode = '{$dbr['GolonganPSBI']}'","psbi_golongan") ;
            $vaset['Golongan']      = $cGolonganPSBI ;
            $vaset['Tgl']           = date_2d($dbr['TanggalRealisasi']) ;
            // $vaset['Saldo']         = $dbr['Debet'] ;
            $vaset['cmdEdit']       = "" ;
            $vaset['cmdDelete']     = "" ;

            $vaset['cmdEdit']       = '<button type="button" onClick="bos.rptpsbi_realisasi.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.rptpsbi_realisasi.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            
            $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	    = html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }
}


?>