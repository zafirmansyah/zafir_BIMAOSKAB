<?php
class Config extends Bismillah_Controller{
    private $bdb;
    public function __construct(){
        parent::__construct() ;
        // $this->load->model('include/func_m') ;
        $this->load->model("config/config_m") ;
        $this->bdb = $this->config_m;
    }

    public function index(){
        $this->load->view("config/config") ;
    }

    public function saving(){
        $va 		= $this->input->post() ;
        $this->config_m->savetransaksi($va) ;
        echo(' alert("Konfigurasi berhasil disimpan ...");') ;
    }
    
    public function seekjasaparkir(){
      $search     = $this->input->get('q');
      $vdb    = $this->config_m->seekjasaparkir($search) ;
      $dbd    = $vdb['db'] ;
      $vare   = array();
      while( $dbr = $this->config_m->getrow($dbd) ){
        $vare[] 	= array("id"=>$dbr['kode'], "text"=>$dbr['keterangan']) ;
      }
      $Result = json_encode($vare);
      echo($Result) ;
   }
}
?>
