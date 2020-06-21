<?php 

/**
 * 
 */
class Msttahun_buku extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('mst/msttahun_buku_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->msttahun_buku_m ;
    }

    public function index(){
        $this->load->view('mst/msttahun_buku') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->msttahun_buku_m->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->msttahun_buku_m->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.msttahun_buku.cmdEdit(\''.$dbr['TahunBuku'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.msttahun_buku.cmdDelete(\''.$dbr['TahunBuku'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	    = html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function init(){
        savesession($this, "ss_tahunbuku_kode", "") ;
    }

    public function saving(){
        $va 	        = $this->input->post() ;
        $cTahunBuku 	= getsession($this, "ss_tahunbuku_kode") ;
        if(empty($cTahunBuku)) $cTahunBuku = $va['cTahunBuku'];
        $this->msttahun_buku_m->saving($cTahunBuku, $va) ;
        echo(' bos.msttahun_buku.init() ; ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cTahunBuku 	    = $va['cTahunBuku'] ;
        $data       = $this->msttahun_buku_m->getdata($cTahunBuku) ;
        if(!empty($data)){
            savesession($this, "ss_tahunbuku_kode", $cTahunBuku) ;
            echo('
                with(bos.msttahun_buku.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    find("#cTahunBuku").val("'.$data['TahunBuku'].'").prop("readonly", true); 
                    find("#cKodeTahunBuku").val("'.$data['KodeTahunBuku'].'").focus() ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->msttahun_buku_m->deleting($va['cTahunBuku']) ;
        echo(' bos.msttahun_buku.grid1_reloaddata() ; ') ;
    }


}

?>