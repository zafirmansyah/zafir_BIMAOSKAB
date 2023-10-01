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
    $sessUsername = getsession($this, 'username');
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
      if($sessJabatan === "000" || $sessUsername == 'asda'){
        $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpd_pegawai.cmdDelete(\''.$dbr['kode'].'\')"
                                    class="btn btn-danger btn-grid">Delete</button>' ;
      }

      $vaset['cmdView']       = '<button type="button" onClick="bos.tcpd_pegawai.cmdView(\''.$dbr['kode'].'\')"
                                    class="btn btn-info btn-grid">Preview</button>' ;

      $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
      $vaset['cmdDelete']	  = html_entity_decode($vaset['cmdDelete']) ;
      $vaset['cmdView']	    = html_entity_decode($vaset['cmdView']) ;


      $vare[]		= $vaset ;
    }

    $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
    echo(json_encode($vare)) ;
  }

  function editing() {
    $cKode = $this->input->post('cKode');
    $data  = $this->bdb->getdata($cKode) ;
    if(!empty($data)){
      echo('
        with(bos.tcpd_pegawai.obj){
          find("#cKode").val("'.$data['kode'].'") ;
          find("#dTgl").val("'. date_2d($data['tanggal']) .'");
          find("#cSubject").val("'. $data['judul'] .'");
          
          tinymce.get("cKomentarPelaksanaanTugas").setContent(`'.$data['komentar_pelaksanaan_tugas'].'`);
          tinymce.get("cAreaPeningkatanKinerja").setContent(`'.$data['area_peningkatan_kinerja'].'`);
          find("#cUsername").val("'. $data['username'] .'");
          find("#cKode").val("'. $data['kode'] .'");  
          find("#cStatus").val("'. $data['status'] .'");
          find(".nav-tabs li:eq(1) a").tab("show") ;
        };
      ');
      // find("#optTahun").val("'. json_encode($data['tahun']) .'");
      // find("#optPeriodeTriwulan").val("'. json_encode($data['periode']) .'");
    }
  }

  function preview(){
    $cKode    = $this->input->post('cKode');
    $vaData   = $this->bdb->getDataPreview($cKode) ;

    // echo print_r($vaData) ; exit() ;

    if(!empty($vaData)){
      $cTahunPeriode    = "Tahun " . $vaData['tahun'] . " Triwulan Ke " . ($vaData['periode'] + 1) ;
      echo('
        with(bos.tcpd_pegawai.obj){
          find(".nav-tabs li:eq(2) a").tab("show") ;

          $("#cJudul").html(`'.$vaData['judul'].'`);
          $("#cPegawaiPelapor").html(`'.$vaData['fullname'].'`);
          $("#dDateTime").html(`'.$vaData['datetime'].'`);
          $("#cPeriode").html(`'.$cTahunPeriode.'`);
          $("#spanKomentar").html(`'.$vaData['komentar_pelaksanaan_tugas'].'`);
          $("#spanTanggapanKomentar").html(`'.$vaData['umpan_balik_evaluasi_kerja'].'`);
          $("#spanAreaPeningkatanKinerja").html(`'.$vaData['area_peningkatan_kinerja'].'`);
          $("#spanTanggapanAreaPeningkatanKinerja").html(`'.$vaData['rencana_pengembangan_pegawai'].'`);
        };
      ');
    }
  }

  function validSaving() {
    $va = $this->input->post();
    // echo(print_r($va)) ;
    $cUsername = $va['cUsername']; //getsession($this,'username');
    $nTahun    = $va['optTahun'];
    $nPeriode  = $va['optPeriodeTriwulan'] ;
    $nStatus   = $va['cStatus'] ;
    $nRow      = 0 ;
    if($nStatus == 0){
      $vaDBCheck = $this->bdb->isUserAlreadyInputOnThisPeriode($cUsername, $nTahun, $nPeriode) ;
      $vaCheck   = $this->bdb->getrow($vaDBCheck["db"]) ;
      $nRow      = $vaCheck['row'] ;
    }
    $lValid    = false ; 
    // echo('alert("'. $cUsername .' || '. $nTahun .' || '. $nPeriode .' || '.  $nStatus .' || row :: '.$nRow.'");');
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

    $isInsert       = "I" ;
    $cKode  = $va['cKode'] ;
    if($cKode == "" || empty(trim($cKode))){
      $cKode = $this->bdb->getKodePerformanceDialog();
    }else{
      $isInsert = "U" ;
    }

    $va['cKode'] = $cKode ;
    $save        = $this->bdb->saveData($va) ;

    $cUsername     = getsession($this, "username") ;
    $cActivityMenu = "PERFORMANCE DIALOG : Pelaporan Kinerja Triwulan" ;
    $cActivityType = ($isInsert == "I") ? "Menyimpan Data Pelaporan Kinerja Triwulan dengan Kode: " . $va['cKode'] : "Merubah Data Pelaporan Kinerja Triwulan dengan Kode : " . $va['cKode'] ;
    $dtDateTime    = date('Y-m-d H:i:s') ;
    $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;

    if($save){
      echo('
          bos.tcpd_pegawai.init() ;
          bos.tcpd_pegawai.grid1_reloaddata() ;
          Swal.fire({
            icon: "success",
            html: "Performance Dialog Anda Berhasil Disimpan"
          });   
      ');
    }
  }

  public function deleting(){
    $va 	= $this->input->post() ;
    $this->bdb->deleting($va['cKode']) ;

    $cUsername     = getsession($this, "username") ;
    $cActivityMenu = "PERFORMANCE DIALOG : Pelaporan Kinerja Triwulan" ;
    $cActivityType = "Menghapus Data Pelaporan Kinerja Triwulan dengan Kode " . $va['cKode'] ;
    $dtDateTime    = date('Y-m-d H:i:s') ;
    $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;


    echo(' 
      Swal.fire({
        icon  : "success",
        title : "Data Deleted!",
      });
      bos.tcpd_pegawai.init() ;
      bos.tcpd_pegawai.grid1_reloaddata() ; 
      bos.tcpd_pegawai.grid1_reload() ; 
    ') ;
}

}