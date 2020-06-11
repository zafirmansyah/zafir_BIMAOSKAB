<?php 

/**
 * 
 */
class mstsurat_jenis extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('mst/mstsurat_jenis_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->mstsurat_jenis_m ;
    }

    public function index(){
        $this->load->view('mst/mstsurat_jenis') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->mstsurat_jenis_m->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->mstsurat_jenis_m->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['cmdedit']    = '<button type="button" onClick="bos.mstsurat_jenis.cmdedit(\''.$dbr['Kode'].'\')"
                            class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmddelete']  = '<button type="button" onClick="bos.mstsurat_jenis.cmddelete(\''.$dbr['Kode'].'\')"
                            class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
            $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function init(){
        savesession($this, "ss_jenissurat_kode", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        $cKode 	    = getsession($this, "ss_jenissurat_kode") ;
        if(empty($cKode)) $cKode = $va['cKode'];
        $this->mstsurat_jenis_m->saving($cKode, $va) ;
        echo(' bos.mstsurat_jenis.init() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->mstsurat_jenis_m->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_jenissurat_kode", $cKode) ;
            echo('
                with(bos.mstsurat_jenis.obj){
                find(".nav-tabs li:eq(1) a").tab("show") ;
                find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                find("#cKeterangan").val("'.$data['Keterangan'].'").focus() ;
                find("#cRubrik").val("'.$data['KodeRubrik'].'") ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->mstsurat_jenis_m->deleting($va['cKode']) ;
        echo(' bos.mstsurat_jenis.grid1_reloaddata() ; ') ;
    }


}

?>