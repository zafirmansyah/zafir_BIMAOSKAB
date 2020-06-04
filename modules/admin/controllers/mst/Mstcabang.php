<?php
class Mstcabang extends Bismillah_Controller{
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstcabang_m') ;
      $this->bdb = $this->mstcabang_m ;
      $this->load->helper('bdate') ;
	}

   public function index(){
      $this->load->view('mst/mstcabang') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->mstcabang_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstcabang_m->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstcabang.cmdedit(\''.$dbr['Kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstcabang.cmddelete(\''.$dbr['Kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "sscabang_kode", "") ;
      savesession($this, "ssidKota_", "") ;
      savesession($this, "ssidKecamatan_", "") ;
   }

   public function saving(){
      $va 	   = $this->input->post() ;
      $cKode 	= getsession($this, "sscabang_kode") ;
      if($cKode == ""){
         $cKode = $this->bdb->getIncreamentKode();
      }
      $this->mstcabang_m->saving($cKode, $va) ;
      echo(' bos.mstcabang.init() ; ') ;
   }

   public function editing(){
      $va 	   = $this->input->post() ;
      $cKode 	= $va['cKode'] ;
      $data    = $this->mstcabang_m->getdata($cKode) ;
      if(!empty($data)){
         savesession($this, "sscabang_kode", $cKode) ;
         $jsonKota[]       = array("id"=>$data['Kota'],"text"=>$data['Kota']. "-" . $this->bdb->getval("Keterangan","Kode = '{$data['Kota']}'","kota")) ;
         $jsonKecamatan[]  = array("id"=>$data['Kecamatan'],"text"=>$data['Kecamatan']. "-" . $this->bdb->getval("Keterangan","Kode = '{$data['Kecamatan']}'","kecamatan")) ;
         $jsonKelurahan[]  = array("id"=>$data['Kelurahan'],"text"=>$data['Kelurahan']. "-" . $this->bdb->getval("Keterangan","Kode = '{$data['Kelurahan']}'","kelurahan")) ;
         echo('
            with(bos.mstcabang.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               $("#cKeterangan").val("'.$data['Keterangan'].'").focus();
               $("#cAlamat").val("'.$data['Alamat'].'");
               $("#optKota").sval('.json_encode($jsonKota).');
               $("#optKecamatan").sval('.json_encode($jsonKecamatan).');
               $("#optKelurahan").sval('.json_encode($jsonKelurahan).');
               $("#cKodePos").val("'.$data['KodePos'].'");
               $("#cNoTelepon").val("'.$data['NoTelepon'].'");
               $("#cNoFax").val("'.$data['NoFax'].'");
               $("#cKode").val("'.$data['Kode'].'") ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstcabang_m->deleting($va['cKode']) ;
      echo(' bos.mstcabang.grid1_reloaddata() ; ') ;
   }

   public function SetSessionKota()
   {
      $idKota = $this->input->post('idKota') ;
      $cKey = "ssidKota_" ;
      savesession($this, $cKey , $idKota) ;
   }

   public function SetSessionKecamatan()
   {
      $idKecamatan = $this->input->post('idKecamatan') ;
      $cKey = "ssidKecamatan_" ;
      savesession($this, $cKey , $idKecamatan) ;
   }

   public function SeekKota()
   {
      $search     = $this->input->get('q');
      $vdb        = $this->bdb->SeekKota($search) ;
      $dbd        = $vdb['db'] ;
      $vare       = array();
      while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }

   public function SeekKecamatan()
   {
      
      $cKota = getsession($this, "ssidKota_") ;
      
      $search     = $this->input->get('q');
      $vdb        = $this->bdb->SeekKecamatan($search,$cKota) ;
      $dbd        = $vdb['db'] ;
      $vare       = array();
      while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }

   public function SeekKelurahan()
   {

      $cKota      = getsession($this, "ssidKota_") ;
      $cKecamatan = getsession($this, "ssidKecamatan_") ;

      $cLocation  = $cKecamatan ;

      $search     = $this->input->get('q');
      $vdb        = $this->bdb->SeekKelurahan($search,$cLocation) ;
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
