<?php
class Mstdatastock extends Bismillah_Controller{
   private $bdb ;
   private $bdbgroupstock ;
   public function __construct(){
		parent::__construct() ;
      $this->load->model('mst/mstdatastock_m') ;
      $this->load->helper('bdate');
      $this->bdb = $this->mstdatastock_m ;
	}

   public function index(){
      $this->load->view('mst/mstdatastock') ;
   }

   public function loadgrid(){
      $va     = json_decode($this->input->post('request'), true) ;
      $vare   = array() ;
      $vdb    = $this->mstdatastock_m->loadgrid($va) ;
      $dbd    = $vdb['db'] ;
      while( $dbr = $this->mstdatastock_m->getrow($dbd) ){
         //$dbr['kode'] = $dbr['kode']."<br/>". $dbr['keterangan'];
         $vaset   = $dbr ;
         $vaset['cmdedit']    = '<button type="button" onClick="bos.mstdatastock.cmdedit(\''.$dbr['kode'].'\')"
                           class="btn btn-success btn-grid">Edit</button>' ;
         $vaset['cmddelete']  = '<button type="button" onClick="bos.mstdatastock.cmddelete(\''.$dbr['kode'].'\')"
                           class="btn btn-danger btn-grid">Delete</button>' ;
         $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
         $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

         $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function init(){
      savesession($this, "ssstock_kode", "") ;
   }

   public function getkode(){
      $n  = $this->bdb->getkode(FALSE) ;

      echo('
        bos.mstdatastock.obj.find("#kode").val("'.$n.'") ;
        ') ;
   }

   public function saving(){
      $va 	= $this->input->post() ;
      $kode 	= getsession($this, "ssstock_kode") ;
      $vimage     = json_decode(getsession($this, "ssmstdatastock_image", "{}"), true) ;
      $va['data_var'] = "";
       if(!empty($vimage)){
         $adir    = $this->config->item('bcore_uploads') ;
         foreach ($vimage as $key => $img) {
            $vi   = pathinfo($img) ;
            $dir  = $adir ;
            $dir .=  $key . "_".date("dmy_Hi") . "." . $vi['extension'] ;
            if(is_file($dir)) @unlink($dir) ;
            if(@copy($img,$dir)){
               @unlink($img) ;
               @unlink($dblast['data_var']) ;
               $va['data_var']   = $dir;
            }
         }  
      }

      $va['data_var'] = json_encode($va['data_var']) ;
      $va['data_var'] = str_replace('"', "", $va['data_var']);
      $this->mstdatastock_m->saving($kode, $va) ;
      savesession($this, "ssmstdatastock_image", "") ;
      echo(' bos.mstdatastock.init() ; ') ;
   }

   public function editing(){
      $va 	= $this->input->post() ;
      $kode 	= $va['kode'] ;
      $data = $this->mstdatastock_m->getdata($kode) ;
      if( $dbr = $this->mstdatastock_m->getrow($data) ){
         savesession($this, "ssstock_kode", $kode) ;
         $satuan[] = array("id"=>$dbr['satuan'],"text"=>$dbr['KetSatuan']);
         $group[] = array("id"=>$dbr['stock_group'],"text"=>$dbr['KetStockGroup']);

         echo('
            with(bos.mstdatastock.obj){
               find(".nav-tabs li:eq(1) a").tab("show") ;
               find("#kode").val("'.$dbr['kode'].'") ;
               find("#hargajual").val("'.$dbr['hargajual'].'") ;
               find("#group").sval('.json_encode($group).') ;
               find("#satuan").sval('.json_encode($satuan).') ;
               find("#keterangan").val("'.$dbr['keterangan'].'").focus() ;
               find("#image").val("") ;

            }
            bos.mstdatastock.obj.find("#idlimage").html("") ;
            bos.mstdatastock.obj.find("#idimage").html("<img src=\"'.$dbr['file_photo'].'\" class=\"img-responsive\" />") ;
            bos.mstdatastock.grid2_lreload = false;
         ') ;
      }
   }

   public function deleting(){
      $va 	= $this->input->post() ;
      $this->mstdatastock_m->deleting($va['kode']) ;
      echo(' bos.mstdatastock.grid1_reloaddata() ; ') ;
   }

   public function seeksatuan(){
      $search     = $this->input->get('q');
      $vdb    = $this->mstdatastock_m->seeksatuan($search) ;
      $dbd    = $vdb['db'] ;
      $vare   = array();
      while( $dbr = $this->mstdatastock_m->getrow($dbd) ){
        $vare[] 	= array("id"=>$dbr['kode'], "text"=>$dbr['keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }
    
   public function seekgroup(){
      $search     = $this->input->get('q');
      $vdb    = $this->mstdatastock_m->seekgroup($search) ;
      $dbd    = $vdb['db'] ;
      $vare   = array();
      while( $dbr = $this->mstdatastock_m->getrow($dbd) ){
        $vare[] 	= array("id"=>$dbr['kode'], "text"=>$dbr['keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }
    
    public function loadgrid2(){
      //$va     = $this->input->get();
      //print_r($va);
      $paket  = getsession($this, "ssstock_kode") ;
      $vare   = array() ;
      $vdb    = $this->mstdatastock_m->loadgrid2($paket) ;
      $dbd    = $vdb['db'] ;
      $n      = 0;
      while( $dbr = $this->mstdatastock_m->getrow($dbd) ){
          $n++;
          $vapaket = $this->mstdatastock_m->checkpaket($paket,$dbr['kode']);
          $ck = $vapaket['status'];
          $vaset   = array("recid"=>$n,"ck"=>$ck,"no"=>$n,"kode"=>$dbr['kode'],"keterangan"=>$dbr['keterangan'],
                           "qty"=>$vapaket['qty'],"satuan"=>$dbr['satuan']) ;
          $vare[]		= $vaset ;
      }

      $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
      echo(json_encode($vare)) ;
   }

   public function saving_image(){
      $fcfg = array("upload_path"=>"./tmp/", "allowed_types"=>"jpg|jpeg|png", "overwrite"=>true) ;

      savesession($this, "ssmstdatastock_image", "") ;
      $this->load->library('upload', $fcfg) ;
      if ( ! $this->upload->do_upload(0) ){
         echo('
            alert("'. $this->upload->display_errors('','') .'") ;
            bos.mstparty.obj.find("#idlimage").html("") ;
         ') ;
      }else{
         $data    = $this->upload->data() ;
         $tname   = str_replace($data['file_ext'], "", $data['client_name']) ;
         $vimage  = array( $tname => $data['full_path']) ;
         savesession($this, "ssmstdatastock_image", json_encode($vimage) ) ;

         echo('
            bos.mstdatastock.obj.find("#idlimage").html("") ;
            bos.mstdatastock.obj.find("#idimage").html("<img src=\"'.base_url("./tmp/" . $data['client_name'] . "?time=". time()).'\" class=\"img-responsive\" />") ;
         ') ;
      }
   }
}
?>
