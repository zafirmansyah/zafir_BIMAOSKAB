<?php 

/**
 * 
 */
class Mstjabatan extends Bismillah_Controller
{
	
	public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstjabatan_m') ;
      $this->load->helper('bdate') ;

      $this->bdb = $this->mstjabatan_m ;
	}

	public function index(){
      $this->load->view('mst/mstjabatan') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->bdb->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->bdb->getrow($dbd) ){
         $vaset   = $dbr ;
         $vaset['cmdShow']  = '<button type="button" onClick="bos.mstjabatan.cmdShow(\''.$dbr['Kode'].'\')"
                           class="btn btn-primary btn-grid">show</button>' ;
         $vaset['cmdShow']	= html_entity_decode($vaset['cmdShow']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function loadgrid_jabatan()
   {
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      // echo('alert("this is '.$va['cKodeDivisi'].'");');
      $vdb    = $this->bdb->loadgrid_jabatan($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->bdb->getrow($dbd) ){
         $vaset   = $dbr ;
         $cGolDivisi          = $dbr['GolonganDivisi'];
         $cKetDivisi          = $this->bdb->getval("Nama", "Kode = '$cGolDivisi'", "golongandivisi") ;
         $vaset['Divisi']     = $cKetDivisi ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstjabatan.cmdedit(\''.$dbr['Kode'].'\')"
                                 class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstjabatan.cmddelete(\''.$dbr['Kode'].'\')"
                                 class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }



   public function init(){
      savesession($this, "ssmstjabatan_kode", "") ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $cKode 	= getsession($this, "ssmstjabatan_kode") ;
      if($cKode == ""){
         $cKode = $this->bdb->getIncreamentKode();
      }

      $this->bdb->saving($cKode, $va) ;
      echo(' bos.mstjabatan.init() ; ') ;
   }

   public function editing(){
      $va 	   = $this->input->post() ;
      $cKode 	= $va['cKodeJabatan'] ;
      $data    = $this->bdb->getdata($cKode) ;
      if(!empty($data)){
         savesession($this, "ssmstjabatan_kode", $cKode) ;
         $jsonDivisi[] = array("id"=>$data['GolonganDivisi'],"text"=>$this->bdb->getval("Nama","Kode = '{$data['GolonganDivisi']}'","golongandivisi")) ;
         echo('
            with(bos.mstjabatan.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#cKodeJabatan").val("'.$cKode.'") ;
               find("#optDivisi").sval('.json_encode($jsonDivisi).');
               find("#cNamaJabatan").val("'.$data['Keterangan'].'").focus() ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->bdb->deleting($va['kode']) ;
      echo(' bos.mstjabatan.grid1_reloaddata() ; ') ;
   }

   public function SeekDivisi(){
      $search     = $this->input->get('q');
      $vdb        = $this->bdb->SeekDivisi($search) ;
      $dbd        = $vdb['db'] ;
      $vare       = array();
      while($dbr = $this->bdb->getrow($dbd)){
          $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Nama']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }

}

 ?>