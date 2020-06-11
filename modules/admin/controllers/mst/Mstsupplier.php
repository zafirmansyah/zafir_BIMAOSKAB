<?php
class Mstsupplier extends Bismillah_Controller{
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstsupplier_m') ;
      $this->load->helper('bdate') ;
	}

   public function index(){
      $this->load->view('mst/mstsupplier') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->mstsupplier_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstsupplier_m->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstsupplier.cmdedit(\''.$dbr['kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstsupplier.cmddelete(\''.$dbr['kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "sssupplier_kode", "") ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $kode 	= getsession($this, "sssupplier_kode") ;
      $this->mstsupplier_m->saving($kode, $va) ;
      echo(' bos.mstsupplier.init() ; ') ;
   }

   public function editing(){
      $va 	= $this->input->post() ;
      $kode 	= $va['kode'] ;
      $data = $this->mstsupplier_m->getdata($kode) ;
      if(!empty($data)){
         savesession($this, "sssupplier_kode", $kode) ;
         echo('
            with(bos.mstsupplier.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#kode").val("'.$data['kode'].'") ;
               find("#nama").val("'.$data['nama'].'").focus() ;
               find("#notelepon").val("'.$data['notelepon'].'") ;
               find("#email").val("'.$data['email'].'") ;
               find("#alamat").val("'.$data['alamat'].'") ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstsupplier_m->deleting($va['kode']) ;
      echo(' bos.mstsupplier.grid1_reloaddata() ; ') ;
   }
}
?>
