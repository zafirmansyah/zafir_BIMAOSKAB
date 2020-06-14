<?php 

/**
 * 
 */
class Tcsurat_keluar extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcsurat_keluar_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcsurat_keluar_m ;
    }

    public function index(){
        $this->load->view('tc/tcsurat_keluar') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['JenisSurat']    = $this->bdb->getval("Keterangan", "Kode = '{$dbr['JenisSurat']}'","jenis_surat") ;
            $vaset['Unit']          = $this->bdb->getval("Keterangan", "Kode = '{$dbr['Unit']}'","golongan_unit") ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdedit']       = '<button type="button" onClick="bos.tcsurat_keluar.cmdedit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmddelete']     = '<button type="button" onClick="bos.tcsurat_keluar.cmddelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
            $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function init(){
        savesession($this, "ss_suratkeluar_", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        $saving     = $this->bdb->saving($va) ;
        $cJenisSurat = $this->bdb->getval("Keterangan","Kode = '{$saving['JenisSurat']}'","jenis_surat");
        echo(' 
            bos.tcsurat_keluar.init() ; 
            Swal.fire({
                icon: "success",
                title: "'.$saving['NoSurat'].'",
                html: "Nomor Jenis Surat <b>' . $cJenisSurat . '</b> Sebagai Berikut"
            });    
        ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_suratkeluar_", $cKode) ;
            echo('
                with(bos.tcsurat_keluar.obj){
                find(".nav-tabs li:eq(1) a").tab("show") ;
                find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                find("#cKeterangan").val("'.$data['Keterangan'].'").focus() ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->bdb->deleting($va['cKode']) ;
        echo(' bos.tcsurat_keluar.grid1_reloaddata() ; ') ;
    }

    public function SeekJenisSurat()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekJenisSurat($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

    
    public function SeekSifatSurat()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->SeekSifatSurat($search) ;
        $dbd        = $vdb['db'] ;
        $vare       = array();
        while($dbr = $this->bdb->getrow($dbd)){
            $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
        }
        $Result = json_encode($vare);
        echo($Result) ;
    }

    public function checkNomorSurat()
    {
        $va          = $this->input->post();
        $cJenisSurat = $va['optJenisSurat'] ;
        $cSifatSurat = $va['optSifatSurat'];
        $checkKode   = $this->bdb->getNomorSuratKeluar($cJenisSurat,$cSifatSurat,false) ;
        echo(' 
            Swal.fire({
                icon: "info",
                title: "'.$checkKode.'"
            });    
        ') ;
    }

}

?>