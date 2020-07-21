<?php

class Rptsuratmasuk_read extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptsuratmasuk_read_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptsuratmasuk_read_m ;
    }

    public function index(){
        $this->load->view('rpt/rptsuratmasuk_read') ;
    }

    public function init(){
        savesession($this, "ss_suratmasuk_", "") ;
        savesession($this, "sstcmsurat_masuk_cUplFile", "") ;
    }
    
    public function loadGridDataUserDisposisi(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadGridDataUserDisposisi($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Unit']          = $this->bdb->getval("Keterangan", "Kode = '{$dbr['Unit']}'","golongan_unit") ;
            $vaset['cmdPilih']      = '<button type="button" onClick="bos.rptsuratmasuk_read.cmdPilih(\''.$dbr['KodeKaryawan'].'\')"
                                        class="btn btn-success btn-grid">Pilih</button>' ;
            $vaset['cmdPilih']	    = html_entity_decode($vaset['cmdPilih']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function getData(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_suratmasuk_", $cKode) ;
            echo('
                with(bos.rptsuratmasuk_read.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSuratDari").val("'.$data['Dari'].'") ;
                    $("#cPerihal").val("'.$data['Perihal'].'") ;
                    $("#cNomorSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTglSurat").val("'.date_2d($data['TglSurat']).'") ;
                    $("#cLastPath").val("'.$data['Path'].'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    bos.rptsuratmasuk_read.gridDisposisi_reload() ;
                }
            ') ;
        }
    }

    public function selectTargetDisposisi()
    {
        $va 	= $this->input->post() ;
        $cKode 	= $va['kode'] ;
        $data   = $this->bdb->getDataTargetDisposisi($cKode) ;
        if(!empty($data)){
            echo('
            with(bos.rptsuratmasuk_read.obj){
               find("#cKodeKaryawan").val("'.$data['KodeKaryawan'].'") ;
               find("#cDisposisi").val("'.$data['fullname'].'");
               bos.rptsuratmasuk_read.loadModalDisposisi("hide");
            }

         ') ;
        }
    }

    public function saving(){
        $va 	    = $this->input->post() ;
  //      print_r($va);
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Forwarded!",
            });
            bos.rptsuratmasuk_read.loadModalForward("hide");
            bos.rptsuratmasuk_read.initDetail() ;     
        ') ;
    }
}


?>