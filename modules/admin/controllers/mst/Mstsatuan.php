<?php
class Mstsatuan extends Bismillah_Controller{
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstsatuan_m') ;
      $this->load->helper('bdate') ;
	}

   public function index(){
      $this->load->view('mst/mstsatuan') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;

      $vare   = array() ;
      $vdb    = $this->mstsatuan_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstsatuan_m->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstsatuan.cmdedit(\''.$dbr['kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstsatuan.cmddelete(\''.$dbr['kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }
      //echo('alert("'.$this->input->post('request').'");');
      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "sssatuan_kode", "") ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $kode 	= getsession($this, "sssatuan_kode") ;
      $this->mstsatuan_m->saving($kode, $va) ;
      echo(' bos.mstsatuan.init() ; ') ;
   }

   public function editing(){
      $va 	= $this->input->post() ;
      $kode 	= $va['kode'] ;
      $data = $this->mstsatuan_m->getdata($kode) ;
      if(!empty($data)){
         savesession($this, "sssatuan_kode", $kode) ;
         echo('
            with(bos.mstsatuan.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#kode").val("'.$data['kode'].'") ;
               find("#keterangan").val("'.$data['keterangan'].'").focus() ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstsatuan_m->deleting($va['kode']) ;
      echo(' bos.mstsatuan.grid1_reloaddata() ; ') ;
   }
}
?>
