<?php

class Rptm02_prinsip_read extends Bismillah_Controller
{
    
    public function __construct(){
        parent::__construct() ;
        $this->load->model('rpt/rptm02_prinsip_read_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->rptm02_prinsip_read_m ;
    }

    public function index(){
        $this->load->view('rpt/rptm02_prinsip_read') ;
    }

    public function init(){
        savesession($this, "ss_m02_prinsip_", "") ;
        savesession($this, "sstcm02_prinsip_read_cUplFile", "") ;
    }
    
    public function loadGridDataUserDisposisi(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadGridDataUserDisposisi($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Unit']          = $this->bdb->getval("Keterangan", "Kode = '{$dbr['Unit']}'","golongan_unit") ;
            $vaset['cmdPilih']      = '<button type="button" onClick="bos.rptm02_prinsip_read.cmdPilih(\''.$dbr['KodeKaryawan'].'\')"
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
            savesession($this, "ss_m02_prinsip_", $cKode) ;
            echo('
                with(bos.rptm02_prinsip_read.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSuratDari").val("'.$data['Dari'].'") ;
                    $("#cPerihal").val("'.$data['Perihal'].'") ;
                    $("#cNomorSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#dTglSurat").val("'.date_2d($data['TglSurat']).'") ;
                    $("#cLastPath").val("'.$data['Path'].'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    bos.rptm02_prinsip_read.gridDisposisi_reload() ;
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
            with(bos.rptm02_prinsip_read.obj){
               find("#cKodeKaryawan").val("'.$data['KodeKaryawan'].'") ;
               find("#cDisposisi").val("'.$data['fullname'].'");
               bos.rptm02_prinsip_read.loadModalDisposisi("hide");
            }

         ') ;
        }
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
            });
            bos.rptm02_prinsip_read.loadModalForward("hide");
            bos.rptm02_prinsip_read.initDetail() ;     
        ') ;
    }

    public function savingFile()
    {
        savesession($this, "ssrptm02_prinsip_read_cUplFile" , "") ;
        $cFileName = "M02Prinsip_". date("Ymd_His")."_";
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"*","overwrite"=>true) ;
                
        $this->load->library('upload', $fcfg) ;
        $nTotalFile = count($_FILES['cUplFile']['name']);
        for($i = 0; $i < $nTotalFile; $i++){
            $_FILES["file"]["name"]     = $cFileName.$_FILES["cUplFile"]["name"][$i];
            $_FILES["file"]["type"]     = $_FILES["cUplFile"]["type"][$i];
            $_FILES["file"]["tmp_name"] = $_FILES["cUplFile"]["tmp_name"][$i];
            $_FILES["file"]["error"]    = $_FILES["cUplFile"]["error"][$i];
            $_FILES["file"]["size"]     = $_FILES["cUplFile"]["size"][$i];
            if ( ! $this->upload->do_upload("file") ){
                echo('
                    alert("'. $this->upload->display_errors('','') .'") ;
                    bos.rptm02_prinsip_read.obj.find("#idcUplFile").html("") ;
                ') ;
            }else{
                $data       = $this->upload->data() ;
                $fname      = "cUplFile" . $data['file_ext'] ;
                $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vFile[$i]  = array( $tname => $data['full_path']) ;
                savesession($this, "ssrptm02_prinsip_read_cUplFile", $vFile ) ;
                echo('
                    //bos.rptm02_prinsip_read.obj.find("#idcUplFile").html("") ;
                    //bos.config.obj.find("#idcUplFile").html("<p>Data Uploaded<p>") ;
                ') ;
            }
        }
    }

    public function actReject()
    {
        $va = $this->input->post();
        $this->bdb->actReject($va);
        echo('
            bos.rptm02_prinsip_read.loadModalReject("hide");
        ');
    } 

    public function actAccept()
    {
        $va = $this->input->post() ;

        $this->bdb->actAccept($va);

        // Upload File Memorandum
        $nYear      = date('Y');
        $cKategori  = "/SuratMemorandumM02";
        $adir       = $this->config->item('bcore_uploads_suratbima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
            mkdir($adir,0777,true);
        }

        $upload         = array("cUplFile"=>getsession($this, "ssrptm02_prinsip_read_cUplFile")) ;
        $va['FilePath'] = ""; 
        $dir            = "" ;
        $fileUploaded   = $upload['cUplFile'];
        if(!empty($fileUploaded)) $this->bdb->deleteFile($va) ;
        foreach ($upload as $key => $value) {
            if(!empty($value)){
                foreach ($value as $tkey => $tval) {
                    if(!empty($tval)){
                        foreach($tval as $fkey=>$file){
                            $vi     = pathinfo($file) ;
                            $dir    = $adir.'/' ;
                            $dir   .=  $vi['filename'] . "." . $vi['extension'] ;
                            if(is_file($dir)) @unlink($dir) ;
                            if(@copy($file,$dir)){
                                @unlink($file) ;
                                $this->bdb->saveconfig($key, $dir) ;
                            }
                            $va['FilePath'] = $dir ;
                            $this->bdb->saveFile($va) ;
                        }
                    }
                }
            }
        }

        echo('
            bos.rptm02_prinsip_read.loadModalAccept("hide");
        ');
    }
}


?>