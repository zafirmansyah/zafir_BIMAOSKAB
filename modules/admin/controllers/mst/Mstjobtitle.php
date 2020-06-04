<?php 

/**
 * 
 */
class Mstjobtitle extends Bismillah_Controller
{
	var $API = "" ;
	public function __construct(){
		parent::__construct() ;
    $this->load->model('mst/mstjobtitle_m') ;
    $this->load->helper('bdate') ;
    $this->API = BISMILLAH_API_URL;
    $this->bdb = $this->mstjobtitle_m ;
	}

	public function index(){
    $va = $this->perhitungan->GetJumlahHariCuti('03-04-2020','10-04-2020');
    // foreach ($va as $key) {
    //   // print_r($key) ;
    //   // $va['nHariCuti'] ;
    // }
    $this->load->view('mst/mstjobtitle',$va) ;
  }

  public function loadgrid(){
    $va     = json_decode($this->input->post('request'), true) ;
    $vare   = array() ;
    $vdb    = $this->mstjobtitle_m->loadgrid($va) ;
    $dbd    = $vdb['db'] ;
    while( $dbr = $this->mstjobtitle_m->getrow($dbd) ){
      $vaset   = $dbr ;
      $vaset['cmdedit']    = '<button type="button" onClick="bos.mstjobtitle.cmdedit(\''.$dbr['Kode'].'\')"
                        class="btn btn-success btn-grid">Edit</button>' ;
      $vaset['cmddelete']  = '<button type="button" onClick="bos.mstjobtitle.cmddelete(\''.$dbr['Kode'].'\')"
                        class="btn btn-danger btn-grid">Delete</button>' ;
      $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
      $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

      $vare[]		= $vaset ;
    }

    $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
    echo(json_encode($vare)) ;
  }

  public function init(){
    savesession($this, "ssjobtitle_kode", "") ;
  }

  public function saving(){
    $va 	   = $this->input->post() ;
    $cKode 	= getsession($this, "ssjobtitle_kode") ;
    if($cKode == ""){
      $cKode = $this->bdb->getIncreamentKode();
    }

    /* Array Parameter Data */
    $cNamaDivisi  = $va['cNamaDivisi'];
    $cDeskripsi   = $va['cDeskripsi'];
    $vaDataAPI    = ['cKode'=>$cKode,'cNama'=>$cNamaDivisi,'cDeskripsi'=>$cDeskripsi];
    
    $insert =  $this->curl->simple_post($this->API.'/storeGolonganDivisi', $vaDataAPI, array(CURLOPT_BUFFERSIZE => 10)); 
    // $this->mstjobtitle_m->saving($cKode, $va) ;
    // echo('alert("'.var_dump($insert).'");');
    if($insert){
      echo('
        bos.mstjobtitle.init() ; 
      ') ;
    }else{
      echo('alert("Oh No!! Something went wrong...");');
    }
  }

   public function editing(){
      $va 	   = $this->input->post() ;
      $cKode 	= $va['cKode'] ;
      $data    = $this->mstjobtitle_m->getdata($cKode) ;
      if(!empty($data)){
         savesession($this, "ssjobtitle_kode", $cKode) ;
         echo('
            with(bos.mstjobtitle.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#cKode").val("'.$data['Kode'].'") ;
               find("#cNamaDivisi").val("'.$data['Nama'].'").focus() ;
               find("#cDeskripsi").val("'.$data['Deskripsi'].'") ;
            }
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstjobtitle_m->deleting($va['kode']) ;
      echo(' bos.mstjobtitle.grid1_reloaddata() ; ') ;
   }


}

 ?>