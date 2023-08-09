<?php 

/**
 * 
 */
class Tcpsbi_komunikasi extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcpsbi_komunikasi_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcpsbi_komunikasi_m ;
    }

    public function index(){
        $this->load->view('tc/tcpsbi_komunikasi') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                      = $dbr ;
            $vaset['WaktuPelaksanaan']  = date_2d($dbr['WaktuPelaksanaan']) ;
            $vaset['Tgl']               = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']           = "" ;
            $vaset['cmdDelete']         = "" ;

            $vaset['cmdEdit']           = '<button type="button" onClick="bos.tcpsbi_komunikasi.cmdEdit(\''.$dbr['Kode'].'\')"
                                            class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']         = '<button type="button" onClick="bos.tcpsbi_komunikasi.cmdDelete(\''.$dbr['Kode'].'\')"
                                            class="btn btn-danger btn-grid">Delete</button>' ;
            
            $vaset['cmdEdit']	        = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	        = html_entity_decode($vaset['cmdDelete']) ;

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

    public function validSaving()
    {
        $va         = $this->input->post();
        $lValid     = true ;
        
        if($lValid){
            $this->saveData($va) ;
        }

    }

    public function saveData($va)
    {
        $cKode      = $va['cKode'];
        $cKey       = "KOM" ;
        if($cKode == "" || trim(empty($cKode))) $va['cKode'] = $this->bdb->getFaktur($cKey,$va['dTgl']);

        if($this->bdb->saveData($va)){
            echo(' 
                bos.tcpsbi_komunikasi.init() ;
                Swal.fire({
                    icon: "success",
                    title: "Sukses",
                    html: "Realisasi Anggaran PSBI Berhasil Disimpan"
                });  
            ') ;
        }

    }

    public function deleting()
    {
        $cKode = $this->input->post('cKode');
        $this->bdb->deleting($cKode);
        echo(' bos.tcpsbi_komunikasi.grid1_reloaddata() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_kodekomunikasipsbi_", $cKode) ;
            // $cLokasiKegiatan        = $data['LokasiKegiatan'] ;
            // $jsonLokasiKegiatan[]   = array("id"=>$cLokasiKegiatan,
            //                                 "text"=>$cLokasiKegiatan." - " . $this->bdb->getval("Keterangan","Kode = '{$cLokasiKegiatan}'","psbi_lokasi")) ;
        
            // $cGolonganPSBI        = $data['GolonganPSBI'] ;
            // $jsonGolonganPSBI[]   = array("id"=>$cGolonganPSBI,
            //                                 "text"=>$cGolonganPSBI." - " . $this->bdb->getval("Keterangan","Kode = '{$cGolonganPSBI}'","psbi_golongan")) ;                                            
            echo('
                with(bos.tcpsbi_komunikasi.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;

                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#cNamaKegiatan").val("'.$data['NamaProgram'].'") ;
                    $("#cUnitKerjaPenyelenggara").val("'.$data['UnitKerja'].'") ;
                    $("#cLatarBelakang").val("'.$data['LatarBelakangKegiatan'].'") ;
                    $("#cTujuan").val("'.$data['Tujuan'].'") ;
                    $("#dTglKegiatan").val("'.date_2d($data['WaktuPelaksanaan']).'") ;
                    $("#cNarasumber").val("'.$data['Narasumber'].'") ;
                    $("#cPeserta").val("'.$data['Peserta'].'") ;
                    $("#cSaluran").val("'.$data['Saluran'].'") ;
                    
                    $("#cPersepsiStakeholder").val("'.$data['PersepsiStakeHolder'].'") ;
                    $("#nRealisasi").val("'.number_format($data['PenggunaanAnggaran']).'") ;
                    $("#cDampakOutput").val("'.$data['DampakOutput'].'") ;

                }
            ') ;
        }
    }

}

?>
