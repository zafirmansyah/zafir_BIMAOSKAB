<?php 

/**
 * 
 */
class Mstgol_jabatan extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('mst/mstgol_jabatan_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->mstgol_jabatan_m ;
    }

    public function index(){
        $this->load->view('mst/mstgol_jabatan') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->mstgol_jabatan_m->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->mstgol_jabatan_m->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['cmdedit']    = '<button type="button" onClick="bos.mstgol_jabatan.cmdedit(\''.$dbr['Kode'].'\')"
                            class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmddelete']  = '<button type="button" onClick="bos.mstgol_jabatan.cmddelete(\''.$dbr['Kode'].'\')"
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
        $this->mstgol_jabatan_m->saving($cKode, $va) ;
        echo(' bos.mstgol_jabatan.init() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->mstgol_jabatan_m->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_golonganunit_kode", $cKode) ;
            echo('
                with(bos.mstgol_jabatan.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                    find("#cKeterangan").val("'.$data['Keterangan'].'").focus() ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->mstgol_jabatan_m->deleting($va['cKode']) ;
        echo(' bos.mstgol_jabatan.grid1_reloaddata() ; ') ;
    }


}

?>