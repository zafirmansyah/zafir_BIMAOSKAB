<?php

class Mstsurat_cetak extends Bismillah_Controller
{   

    public function __construct(){
        parent::__construct() ;
        $this->load->model('mst/mstsurat_cetak_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->mstsurat_cetak_m ;
    }

    public function index(){
        $this->load->view('mst/mstsurat_cetak') ;
    }

    public function init(){
        savesession($this, "ssmstsurat_cetak_cKode", "") ;
        savesession($this, "ssmstsurat_cetak_cUplFileTEMPLATE", "") ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                  = $dbr ;
            $cURLFile               = $this->bdb->getval("FilePath","Kode = '{$dbr['Kode']}'","cetak_dokumen_file") ;
            $vaset['cmdedit']       = "";
            $vaset['cmddelete']     = "";
            
            if(getsession($this,"Jabatan") == "002"){
                $vaset['cmdedit']       = '<button type="button" onClick="bos.mstsurat_cetak.cmdedit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
                $vaset['cmddelete']     = '<button type="button" onClick="bos.mstsurat_cetak.cmddelete(\''.$dbr['Kode'].'\')"
                                            class="btn btn-danger btn-grid">Delete</button>' ;
            }
            $vaset['cmdDownload']   = '<button type="button" onClick="bos.mstsurat_cetak.cmdDownload(\''.$cURLFile.'\')"
                                        class="btn btn-info btn-grid" target="_blank">Download</button>' ;
            $vaset['cmdedit']	    = html_entity_decode($vaset['cmdedit']) ;
            $vaset['cmddelete']	    = html_entity_decode($vaset['cmddelete']) ;
            $vaset['cmdDownload']	= html_entity_decode($vaset['cmdDownload']) ;
            
            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        
        $vaKode         = $va['cKode'];
        if($vaKode == "" || trim(empty($vaKode))){
            $cKode = $this->bdb->getKodeTemplate() ;
        }else{
            $cKode = $vaKode ;
        }

        $va['cKode'] = $cKode ;

        $nYear      = date('Y');
        $cKategori  = "TEMPLATES";
        $adir       = $this->config->item('bcore_uploads_templatebima') . $cKategori ;
        if(!is_dir($adir)){
            mkdir($adir,0777,true);
        }

        $upload         = array("cUplFileTEMPLATE"=>getsession($this, "ssmstsurat_cetak_cUplFileTEMPLATE")) ;
        $va['FilePath'] = ""; 
        $dir            = "" ;
        if(!empty($upload)){
            $this->bdb->deleteFile($va) ;
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
        }

        savesession($this, "ssmstsurat_cetak_cUplFileTEMPLATE" , "") ;
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
            });
            bos.mstsurat_cetak.init() ;     
        ') ;
    }
    public function editing()
    {
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ssmstsurat_cetak_cKode", $cKode) ;
            echo('
                with(bos.mstsurat_cetak.obj){
                find(".nav-tabs li:eq(1) a").tab("show") ;
                find("#cKode").val("'.$data['Kode'].'").prop("readonly", true); 
                find("#cKeterangan").val("'.$data['Subject'].'").focus() ;
                }
            ') ;
        }
    }
    public function savingFile()
    {
        savesession($this, "ssmstsurat_cetak_cUplFileTEMPLATE" , "") ;
        $cFileName = "TEMPLATES_". date("Ymd_His");
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"docx","overwrite"=>true) ;
                
        $this->load->library('upload', $fcfg) ;
        $nTotalFile = count($_FILES['cUplFileTEMPLATE']['name']);
        if($nTotalFile > 0){
            for($i = 0; $i < $nTotalFile; $i++){
                $_FILES["file"]["name"]     = $cFileName.$_FILES["cUplFileTEMPLATE"]["name"][$i];
                $_FILES["file"]["type"]     = $_FILES["cUplFileTEMPLATE"]["type"][$i];
                $_FILES["file"]["tmp_name"] = $_FILES["cUplFileTEMPLATE"]["tmp_name"][$i];
                $_FILES["file"]["error"]    = $_FILES["cUplFileTEMPLATE"]["error"][$i];
                $_FILES["file"]["size"]     = $_FILES["cUplFileTEMPLATE"]["size"][$i];
                if ( ! $this->upload->do_upload("file") ){
                    echo('
                        alert("'. $this->upload->display_errors('','') .'") ;
                        bos.mstsurat_cetak.obj.find("#idcUplFileTEMPLATE").html("") ;
                    ') ;
                }else{
                    $data       = $this->upload->data() ;
                    $fname      = "cUplFileTEMPLATE" . $data['file_ext'] ;
                    $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                    $vFile[$i]  = array( $tname => $data['full_path']) ;
                    savesession($this, "ssmstsurat_cetak_cUplFileTEMPLATE", $vFile ) ;
                    echo('
                        //bos.mstsurat_cetak.obj.find("#idcUplFileTEMPLATE").html("") ;
                        //bos.mstsurat_cetak.obj.find("#idcUplFileTEMPLATE").html("<p>Data Uploaded<p>") ;
                    ') ;
                }
            }
        }
    }
    public function deleting(){
        $va 	= $this->input->post() ;
        $this->bdb->deleting($va['cKode']) ;
        $this->bdb->deleteFile($va) ;
        echo(' bos.mstsurat_cetak.grid1_reloaddata() ; ') ;
    }
}


?>