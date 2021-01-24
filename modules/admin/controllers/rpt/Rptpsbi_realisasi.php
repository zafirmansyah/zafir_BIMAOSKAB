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
            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function SeekGolonganPSBI($value='')
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekGolonganPSBI($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

    public function SeekLokasiPSBI($value='')
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekLokasiPSBI($search) ;
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