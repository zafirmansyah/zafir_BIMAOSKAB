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
      // echo(print_r($dbr));
      /**
        [uname_pelapor] => suworo 
        [fullname_pelapor] => suworo 
        [status] => 3 
       */
      $cUsernamePelaporan = $dbr['uname_pelapor'] ;
      $lStatus  = $this->bdb->getStatusLaporanByUname($cUsernamePelaporan) ;
      $cStatus  = "<span class='text-default'>New<span>";
      $btnClass = "btn-default";
      if($lStatus == "1"){ //proses
          $cStatus  = "<span class='text-success'>Disetujui<span>";
      }else if($lStatus == "2"){ //pending
          $cStatus  = "<span class='text-danger'>On Revisi<span>";
      }else if($lStatus == "3"){ // reject
          $cStatus  = "<span class='text-warning'>Belum Ditanggapi<span>";
      }
      
      $vaset   = $dbr ;
      // $vaset['tanggal']       = date_2d($dbr['tanggal']) ;
      $vaset['status']        = html_entity_decode($cStatus);
      $vaset['cmdEdit']       = "" ;
      if($lStatus == 3 || $sessJabatan === "000"){
        $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcpd_pegawai.cmdEdit(\''.$cUsernamePelaporan.'\')"
                                    class="btn btn-info btn-grid">Lihat Detail</button>' ;
      }
      $vaset['cmdDelete'] = "" ;
      if($sessJabatan === "000"){
        $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcpd_pegawai.cmdDelete(\''.$cUsernamePelaporan.'\')"
                                    class="btn btn-danger btn-grid">Delete</button>' ;
      }
      $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
      $vaset['cmdDelete']	  = html_entity_decode($vaset['cmdDelete']) ;

      $vare[]		= $vaset ;
    }

    $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
    echo(json_encode($vare)) ;
  }



}