<?php 

/**
 * 
 */
class Mstpsbi_golongan extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('mst/mstpsbi_golongan_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->mstpsbi_golongan_m ;
    }

    public function index(){
        $this->load->view('mst/mstpsbi_golongan') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->mstpsbi_golongan_m->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->mstpsbi_golongan_m->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['cmdedit']    = '<button type="button" onClick="bos.mstpsbi_golongan.cmdedit(\''.$dbr['Kode'].'\')"
                            class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmddelete']  = '<button type="button" onClick="bos.mstpsbi_golongan.cmddelete(\''.$dbr['Kode'].'\')"
                            class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
            $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function init(){
        savesession($this, "ss_golonganunit_kode", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        $cKode 	    = getsession($this, "ss_golonganunit_kode") ;
        if(empty($cKode)) $cKode = $va['cKode'];
        $this->mstpsbi_golongan_m->saving($cKode, $va) ;
        echo(' bos.mstpsbi_golongan.init() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->mstpsbi_golongan_m->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_golonganunit_kode", $cKode) ;
            echo('
                with(bos.mstpsbi_golongan.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                    find("#cKeterangan").val("'.$data['Keterangan'].'").focus() ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->mstpsbi_golongan_m->deleting($va['cKode']) ;
        echo(' bos.mstpsbi_golongan.grid1_reloaddata() ; ') ;
    }


}

?>