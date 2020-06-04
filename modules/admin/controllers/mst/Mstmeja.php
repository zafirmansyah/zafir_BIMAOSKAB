<?php
class Mstmeja extends Bismillah_Controller{
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstmeja_m') ;
      $this->load->helper('bdate') ;
	}

   public function index(){
      $this->load->view('mst/mstmeja') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->mstmeja_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstmeja_m->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstmeja.cmdedit(\''.$dbr['kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstmeja.cmddelete(\''.$dbr['kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "ssmeja_kode", "") ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $kode 	= getsession($this, "ssmeja_kode") ;
      $this->mstmeja_m->saving($kode, $va) ;
      echo(' bos.mstmeja.init() ; ') ;
   }

   public function editing(){
      $va 	= $this->input->post() ;
      $kode 	= $va['kode'] ;
      $data = $this->mstmeja_m->getdata($kode) ;
      if(!empty($data)){
         savesession($this, "ssmeja_kode", $kode) ;
         echo('
            with(bos.mstmeja.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#kode").val("'.$data['kode'].'") ;
               find("#keterangan").val("'.$data['keterangan'].'").focus() ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstmeja_m->deleting($va['kode']) ;
      echo(' bos.mstmeja.grid1_reloaddata() ; ') ;
   }
}
?>
