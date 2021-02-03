<?php 

/**
 * 
 */
class Tcpsbi_realisasi extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcpsbi_realisasi_m') ;
        $this->load->model("func/updtransaksi_m") ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcpsbi_realisasi_m ;
    }

    public function index(){
        $this->load->view('tc/tcpsbi_realisasi') ;
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

            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcpsbi_realisasi.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpsbi_realisasi.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            
            $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
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
        $cGolongan  = $va['optGolonganPSBI'];
        $cKey       = "R" . $cGolongan ;
        if($cKode == "" || trim(empty($cKode))) $va['cKode'] = $this->bdb->getFaktur($cKey,$va['dTgl']);

        if($this->bdb->saveData($va)){
            echo(' 
                bos.tcpsbi_realisasi.init() ;
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
        echo(' bos.tcpsbi_realisasi.grid1_reloaddata() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_koderealisasipsbi_", $cKode) ;
            $cLokasiKegiatan        = $data['LokasiKegiatan'] ;
            $jsonLokasiKegiatan[]   = array("id"=>$cLokasiKegiatan,
                                            "text"=>$cLokasiKegiatan." - " . $this->bdb->getval("Keterangan","Kode = '{$cLokasiKegiatan}'","psbi_lokasi")) ;
        
            $cGolonganPSBI        = $data['GolonganPSBI'] ;
            $jsonGolonganPSBI[]   = array("id"=>$cGolonganPSBI,
                                            "text"=>$cGolonganPSBI." - " . $this->bdb->getval("Keterangan","Kode = '{$cGolonganPSBI}'","psbi_golongan")) ;                                            
            echo('
                with(bos.tcpsbi_realisasi.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                    find("#dTglKegiatan").val("'.date_2d($data['WaktuKegiatan']).'");
                    find("#optGolonganPSBI").sval('.json_encode($jsonGolonganPSBI).');
                    find("#dTgl").val("'.date_2d($data['TanggalRealisasi']).'");
                    find("#cNamaKegiatan").val("'.$data['NamaKegiatan'].'");
                    find("#cPenerimaManfaat").val("'.$data['PenerimaManfaat'].'");
                    find("#cTujuanManfaat").val("'.$data['TujuanManfaat'].'");
                    find("#cRuangLingkup").val("'.$data['RuangLingkup'].'");
                    find("#nPengajuan").val("'.number_format($data['NilaiPengajuan']).'");
                    find("#optLokasiPSBI").sval('.json_encode($jsonLokasiKegiatan).');
                    find("#cDetailLokasi").val("'.$data['DetailLokasi'].'");
                    find("#cPesertaPartisipan").val("'.$data['PesertaPartisipan'].'");
                    find("#cPermasalahan").val("'.$data['Permasalahan'].'");
                    find("#cNoSuratProposal").val("'.$data['NomorSuratProposal'].'");
                    find("#cJenisBantuan").val("'.$data['JenisBantuan'].'");
                    find("#cDetailBantuan").val("'.$data['DetailBantuan'].'");
                    find("#cKodeM02").val("'.$data['KodeM02Persetujuan'].'");
                    find("#dTglM02").val("'.date_2d($data['TanggalPersetujuan']).'");
                    find("#cVendor").val("'.$data['Vendor'].'");
                    find("#nRealisasi").val("'.number_format($data['NilaiRealisasi']).'");
                }
            ') ;
        }
    }

}

?>
