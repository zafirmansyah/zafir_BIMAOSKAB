<?php 

/**
 * 
 */
class Tcpsbi_mutanggaran extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcpsbi_mutanggaran_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcpsbi_mutanggaran_m ;
    }

    public function index(){
        $this->load->view('tc/tcpsbi_mutanggaran') ;
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
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['Saldo']         = $dbr['Debet'] ;
            // $vaset['cmdEdit']       = "" ;
            $vaset['cmdDelete']     = "" ;

            // $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcpsbi_mutanggaran.cmdEdit(\''.$dbr['Faktur'].'\')"
            //                             class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpsbi_mutanggaran.cmdDelete(\''.$dbr['Faktur'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            
            // $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	    = html_entity_decode($vaset['cmdDelete']) ;

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

    public function saving()
    {
        $va = $this->input->post() ;
        $save   = $this->bdb->saving($va) ;
        if($save){
            echo('
                bos.tcpsbi_mutanggaran.init() ;
                bos.tcpsbi_mutanggaran.grid1_reloaddata() ;
                Swal.fire({
                    icon: "success",
                    title: "Save Complete",
                    html: "Anggaran Realisasi PSBI Berhasil Disimpan"
                });   
            ');
        } //bos.tcpsbi_mutanggaran.initTab1() ;
    }

    public function deleting()
    {
        $cKode = $this->input->post('cKode');
        $this->bdb->deleting($cKode);
        echo(' bos.tcpsbi_mutanggaran.grid1_reloaddata() ; ') ;
    }

}