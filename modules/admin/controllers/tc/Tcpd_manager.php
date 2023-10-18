<?php 

/**
 * 
 */
class tcpd_manager extends Bismillah_Controller
{
        
  public function __construct(){
    parent::__construct() ;
    $this->load->model('tc/tcpd_manager_m') ;
    $this->load->helper('bdate') ;

    $this->bdb = $this->tcpd_manager_m ;
  }

  public function index(){
    $va['cUsername'] = getsession($this,'username') ;
    $va['cSuperior'] = getsession($this,'superior') ;
    $this->load->view('tc/tcpd_manager', $va) ;
  }

  public function loadgrid(){
    $sessJabatan = getsession($this, 'Jabatan');
    $va     = json_decode($this->input->post('request'), true) ;
    $vare   = array() ;
    $vdb    = $this->bdb->loadgrid($va) ;
    $dbd    = $vdb['db'] ;
    while( $dbr = $this->bdb->getrow($dbd) ){
      $cUsernamePelaporan = $dbr['uname_pelapor'] ;
      $lStatus            = $this->bdb->getStatusLaporanByUname($cUsernamePelaporan) ;
      $cPeriodeLastInput  = $this->bdb->getDataLastPeriodeInserted($cUsernamePelaporan) ;
      $btnClass           = "btn-default";
      if($lStatus == 1){ //proses
          $cStatus  = "<span class='text-success'>Disetujui<span>";
      }else if($lStatus == 2){ //pending
          $cStatus  = "<span class='text-danger'>On Revisi<span>";
      }else if($lStatus == 3){ // reject
          $cStatus  = "<span class='text-warning'>Belum Ditanggapi<span>";
      }
      
      $vaset                          = $dbr ;
      $vaset['periode_last_inserted'] = $cPeriodeLastInput ;
      $vaset['status']                = html_entity_decode($cStatus);
      $vaset['cmdEdit']               = '<button type="button" onClick="bos.tcpd_manager.cmdEdit(\''.$cUsernamePelaporan.'\')"
                                         class="btn btn-info btn-grid">Lihat Detail</button>' ;
      $vaset['cmdDelete'] = "" ;
      if($sessJabatan === "000"){
        $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpd_manager.cmdDelete(\''.$cUsernamePelaporan.'\')"
                                    class="btn btn-danger btn-grid">Delete</button>' ;
      }
      $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
      $vaset['cmdDelete']	  = html_entity_decode($vaset['cmdDelete']) ;

      $vare[]		= $vaset ;
    }

    $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
    echo(json_encode($vare)) ;
  }

  function refreshTriwulan(){
    $va             = $this->input->post() ;
    $nPeriode       = $va['periode'] ;
    $nTahun         = $va['tahun'] ;
    $cUnameKaryawan = $va['uname_karyawan'] ;
    if(!$cUnameKaryawan){
      echo('
        with(bos.tcpd_manager.obj){
          find(".nav-tabs li:eq(0) a").tab("show") ;
          Swal.fire({
            icon: "error",
            title: "Silahkan Pegawai Pelapor Terlebih Dahulu" ,
          });   
        };
      ');
    }
    $vaData         = $this->bdb->getdata($va) ;
    if(!empty($vaData)){
      $cTahunPeriode    = "Tahun " . $vaData['tahun'] . " Triwulan Ke " . ($vaData['periode'] + 1) ;
      $jsonTahun[] 	    = array("id"=>$vaData['tahun'],"text"=>$vaData['tahun']);
      $cTextPeriode = "Triwulan ";
      $nPeriode = ($vaData['periode'] + 1) ;
      // echo('alert("TRESNO : '. $nPeriode .' || type '. gettype($nPeriode) .'");');
      if($nPeriode == 1){
        $cTextPeriode .= "I" ;
      }else if($nPeriode == 2){
        $cTextPeriode .= "II" ;
      }else if($nPeriode == 3){
        $cTextPeriode .= "III" ;
      }else{
        $cTextPeriode .= "IV" ;
      }
      $jsonPeriode[] 	  = array("id"=>$vaData['periode'],"text"=>$cTextPeriode);
      echo('
        with(bos.tcpd_manager.obj){
          $("#cJudul").html(`'.$vaData['judul'].'`);
          $("#cPegawaiPelapor").html(`'.$vaData['fullname'].'`);
          $("#dDateTime").html(`'.$vaData['tanggal'].'`);
          $("#cPeriode").html(`'.$cTahunPeriode.'`);
          $("#spanKomentar").html(`'.$vaData['komentar_pelaksanaan_tugas'].'`);
          $("#spanTanggapanKomentar").html(`'.$vaData['umpan_balik_evaluasi_kerja'].'`);
          $("#spanAreaPeningkatanKinerja").html(`'.$vaData['area_peningkatan_kinerja'].'`);
          $("#spanTanggapanAreaPeningkatanKinerja").html(`'.$vaData['rencana_pengembangan_pegawai'].'`);
          $("#cSubject").val("'.$vaData['judul'].'");
          $("#cKode").val("'. $vaData['kode'] .'");

          tinymce.get("cKomentarPelaksanaanTugas").setContent(`'.$vaData['umpan_balik_evaluasi_kerja'].'`);
          tinymce.get("cAreaPeningkatanKinerja").setContent(`'.$vaData['rencana_pengembangan_pegawai'].'`);

          $("#optTahun2").sval('. json_encode($jsonTahun) .');
          $("#optPeriodeTriwulan2").sval('. json_encode($jsonPeriode) .');

        };
      ');
      // $("#optTahun").val();
      // $("#optPeriodeTriwulan").val();
    }else{
      echo('
        with(bos.tcpd_manager.obj){
          $("#cJudul").html("");
          $("#cPegawaiPelapor").html("");
          $("#dDateTime").html("");
          $("#cPeriode").html("");
          $("#spanKomentar").html("");
          $("#spanTanggapanKomentar").html("");
          $("#spanAreaPeningkatanKinerja").html("");
          $("#spanTanggapanAreaPeningkatanKinerja").html("");
          $("#cSubject").val("");
          $("#cKomentarPelaksanaanTugas").val("");
          $("#cAreaPeningkatanKinerja").val("");
        };
      ');
    }
  }

  function editNoComent(){
    $va = $this->input->post();
    $cKode = $va['cKode'];
    $this->bdb->editNoComent($cKode) ;

    $cUsername     = getsession($this, "username") ;
    $cActivityMenu = "PERFORMANCE DIALOG : Tanggapan Kinerja" ;
    $cActivityType = "Memberikan Akses kepada Pegawai untuk Bisa Melakukan Perubagan atas Pelaporan Kinerja Triwulan Dengan Kode Data : " . $cKode ;
    $dtDateTime    = date('Y-m-d H:i:s') ;
    $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;

    echo(' 
      Swal.fire({
          icon  : "success",
          title : "Data Akan Dilakukan Koreksi Oleh Pegawai",
      });
      bos.tcpd_manager.init() ;
      bos.tcpd_manager.grid1_reloaddata() ; 
      bos.tcpd_manager.grid1_reload() ; 
    ') ;
  }

  function editing() {
    $cUname = $this->input->post('cUsernamePelaporan');
    echo('
      with(bos.tcpd_manager.obj){
        find("#cUsernameKaryawan").val("'. $cUname .'");
        find(".nav-tabs li:eq(1) a").tab("show") ;
        Swal.fire({
          icon: "info",
          title: "Silahkan Pilih Tahun dan Periode Pelaporan Untuk Melihat Detail Laporan" ,
        });   
      };
    ');
  }

  function validSaving() {
    $va = $this->input->post() ;
    // echo(print_r($va));

    /*
    [dTgl]                      => 13-09-2023
    [cSubject]                  => ABCD
    [cKomentarPelaksanaanTugas] => 
    [cAreaPeningkatanKinerja]   => 
    [nNo]                       => 0
    [cUsername]                 => asda
    [cUsernameKaryawan]         => asda
    [cKode]                     => PDLG202309.017
    [cStatus]                   => 
    [cLastPath]                 => 
    */

    if(!isset($va['cKomentarPelaksanaanTugas']) || !isset($va['cAreaPeningkatanKinerja'])){
      echo('
        Swal.fire({
          icon: "error",
          title: "Data Tidak Valid" ,
          text : "Silahkan Input Komentar Terlebih Dahulu"
        });   
      ');
    }else if(!$va['cKode']){
      echo('
        Swal.fire({
          icon: "error",
          title: "Oops!!" ,
          text : "Sepertinya Anda Belum Memilih Data Dengan Benar"
        });   
      ');
    }else{
      $this->saveData($va) ;
    } 
  }

  function saveData($va) {
    $doSaveData   = $this->bdb->saveData($va);

    $cUsername     = getsession($this, "username") ;
    $cActivityMenu = "PERFORMANCE DIALOG : Tanggapan Kinerja" ;
    $cActivityType = "Melakukan pengisian tanggapan komentar terhadap pelaporan kinerja triwulan dengan Kode Data : ". $va['cKode'];
    $dtDateTime    = date('Y-m-d H:i:s') ;
    $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;

    if($doSaveData){
      echo('
          bos.tcpd_manager.init() ;
          bos.tcpd_manager.grid1_reloaddata() ;
          Swal.fire({
            icon: "success",
            html: "Tanggapan Performance Dialog Anda Berhasil Disimpan"
          });   
      ');
    }
  }


}