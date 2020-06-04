<?php
class Mstgroupstock extends Bismillah_Controller{
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstgroupstock_m') ;
      $this->load->helper('bdate') ;
	}

   public function index(){
      $this->load->view('mst/mstgroupstock') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->mstgroupstock_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstgroupstock_m->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstgroupstock.cmdedit(\''.$dbr['kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstgroupstock.cmddelete(\''.$dbr['kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "ssgroupstock_kode", "") ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $kode 	= getsession($this, "ssgroupstock_kode") ;
      $this->mstgroupstock_m->saving($kode, $va) ;
      echo(' bos.mstgroupstock.init() ; ') ;
   }

   public function editing(){
      $va 	= $this->input->post() ;
      $kode 	= $va['kode'] ;
      $data = $this->mstgroupstock_m->getdata($kode) ;
      if(!empty($data)){
         savesession($this, "ssgroupstock_kode", $kode) ;
         echo('
            with(bos.mstgroupstock.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#kode").val("'.$data['kode'].'") ;
               find("#keterangan").val("'.$data['keterangan'].'").focus() ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstgroupstock_m->deleting($va['kode']) ;
      echo(' bos.mstgroupstock.grid1_reloaddata() ; ') ;
   }
}
?>
