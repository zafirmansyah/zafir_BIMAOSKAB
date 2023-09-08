<?php 

/**
 * 
 */
class tcpd_pegawai extends Bismillah_Controller
{
        
  public function __construct(){
    parent::__construct() ;
    $this->load->model('tc/tcpd_pegawai_m') ;
    $this->load->helper('bdate') ;

    $this->bdb = $this->tcpd_pegawai_m ;
  }

  public function index(){
    $va['cUsername'] = getsession($this,'username') ;
    $va['cSuperior'] = getsession($this,'superior') ;
    $this->load->view('tc/tcpd_pegawai', $va) ;
  }

  public function loadgrid(){
    $sessJabatan = getsession($this, 'Jabatan');
    $va     = json_decode($this->input->post('request'), true) ;
    $vare   = array() ;
    $vdb    = $this->bdb->loadgrid($va) ;
    $dbd    = $vdb['db'] ;
    while( $dbr = $this->bdb->getrow($dbd) ){
      // echo(print_r($dbr));
      /**
       *  [kode]                       => PD0001
       *  [tanggal]                    => 2023-08-01
       *  [Periode]                    => 2023 - Triwulan1
       *  [judul]                      => JUDUL PERFORMANCE DIALOG
       *  [komentar_pelaksanaan_tugas] => lalalalala yeyeyeye
       *  [area_peningkatan_kinerja]   => hahahaha hihihihi
       *  [status]                     => 0
       */
      $lStatus  = $dbr['status'];
      $cStatus  = "<span class='text-default'>New<span>";
      $btnClass = "btn-default";
      if($lStatus == "1"){ //proses
          $cStatus  = "<span class='text-success'>Disetujui<span>";
      }else if($lStatus == "2"){ //pending
          $cStatus  = "<span class='text-danger'>Revisi<span>";
      }else if($lStatus == "3"){ // reject
          $cStatus  = "<span class='text-warning'>Menunggu Persetujuan<span>";
      }
      
      $vaset   = $dbr ;
      $vaset['tanggal']       = date_2d($dbr['tanggal']) ;
      $vaset['status']        = html_entity_decode($cStatus);
      $vaset['cmdEdit']       = "" ;
      if($lStatus == 2 || $sessJabatan === "000"){
        $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcpd_pegawai.cmdEdit(\''.$dbr['kode'].'\')"
                                    class="btn btn-success btn-grid">Edit</button>' ;
      }
      $vaset['cmdDelete'] = "" ;
      if($sessJabatan === "000"){
        $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpd_pegawai.cmdDelete(\''.$dbr['kode'].'\')"
                                    class="btn btn-danger btn-grid">Delete</button>' ;
      }
      $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
      $vaset['cmdDelete']	  = html_entity_decode($vaset['cmdDelete']) ;

      $vare[]		= $vaset ;
    }

    $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
    echo(json_encode($vare)) ;
  }

  function validSaving() {
    $va = $this->input->post();
    // echo(print_r($va)) ;
    $cUsername = getsession($this,'username');
    $nTahun    = $va['optTahun'];
    $nPeriode  = $va['optPeriodeTriwulan'] ;
    $vaDBCheck = $this->bdb->isUserAlreadyInputOnThisPeriode($cUsername, $nTahun, $nPeriode) ;
    $vaCheck   = $this->bdb->getrow($vaDBCheck["db"]) ;
    $nRow      = $vaCheck['row'] ;
    // echo("WADUHH => " . print_r($vaCheck)  . " || " . $nRow );
    $lValid    = false ; 
    if($nRow < 1){
      $lValid = true ;
    }

    if(!$lValid){
      echo('
        Swal.fire({
          icon: "error",
          title: "Data Tidak Valid" ,
          text : "Anda Sudah Pernah Input Data Pelaporan Untuk Periode Terpilih"
        });   
      ');
    }else{
      $this->saveData($va) ;
    }
  }

  function saveData($va) {  
    /**
     * 
     * [dTgl] => 31-08-2023 
     * [cSubject] => 😘 
     * [optTahun] => 2023 
     * [optPeriodeTriwulan] => 0 
     * [cKomentarPelaksanaanTugas] => 
     * [cAreaPeningkatanKinerja] => 
     * [nNo] => 0 
     * [cUsername] => asda 
     * [cKode] => 
     * [cStatus] => 
     * [cLastPath] => 
     */
    $cKode  = $va['cKode'] ;
    if($cKode == "" || empty(trim($cKode))){
      $cKode = $this->bdb->getKodePerformanceDialog();
    }

    $va['cKode'] = $cKode ;
    $save        = $this->bdb->saveData($va) ;
    if($save){
      echo('
          bos.tcpd_pegawai.init() ;
          bos.tcpd_pegawai.grid1_reloaddata() ;
          Swal.fire({
              icon: "success",
              html: "Nomor Surat <b> M.02 Persetujuan Prinsip </b> Sebagai Berikut"
          });   
      ');
    }
  }

}