<?php 

/**
 * 
 */
class Tciku_form extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tciku_form_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tciku_form_m ;
    }

    public function index(){
        $this->load->view('tc/tciku_form') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tciku_form.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tciku_form.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	   = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	= html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }


    public function init(){
        savesession($this, "ss_ikumaster_", "") ;
        savesession($this, "sstcmiku_master_cUplFileFormIKU", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        
        $cKode         = $va['optKodeIKU'];
        
        $nYear      = date('Y');
        $cKategori  = "/IKU-FORM";
        $adir       = $this->config->item('bcore_uploads_ikubima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
             mkdir($adir,0777,true);
            echo('
                bos.tciku_form.init() ; 
                Swal.fire({
                    icon: "warning",
                    title: "Hallo, bisa mkdir gak ya?"
                });   
            ');
        }

        $upload         = array("cUplFileFormIKU"=>getsession($this, "sstciku_form_cUplFileFormIKU")) ;
        $va['FilePath'] = ""; 
        $dir            = "" ;
        $fileUploaded   = $upload['cUplFileFormIKU'];
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
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
            });
            bos.tciku_form.init() ;     
        ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            savesession($this, "ss_tciku_form_", $cKode) ;
            echo('
                with(bos.tciku_form.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSubject").val("'.$data['Subject'].'") ;
                    $("#cDeskripsi").val("'.$data['Deskripsi'].'") ;
                    $("#cPeriode").val("'.$data['Periode'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->bdb->deleting($va['cKode']) ;
        echo(' 
            bos.tciku_form.grid1_reloaddata() ; 
            bos.tciku_form.grid1_reload() ; 
        ') ;
    }


    public function seekKodeIKU()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekKodeIKU($search) ;
        $dbd        = $vdb['db'];
        $vare       = array();
        while($dbr  = $this->bdb->getrow($dbd)){
            $vare[] = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] . " - ". $dbr['Subject']) ;
        }
        $Result = json_encode($vare);
        echo($Result);
    }


    public function savingFile()
    {
        savesession($this, "sstciku_form_cUplFileFormIKU" , "") ;
        $cFileName = "IKU_". date("Ymd_His");
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"*","overwrite"=>true) ;
                
        $this->load->library('upload', $fcfg) ;
        $nTotalFile = count($_FILES['cUplFileFormIKU']['name']);
        if($nTotalFile > 0){
            for($i = 0; $i < $nTotalFile; $i++){
                $_FILES["file"]["name"]     = $cFileName.$_FILES["cUplFileFormIKU"]["name"][$i];
                $_FILES["file"]["type"]     = $_FILES["cUplFileFormIKU"]["type"][$i];
                $_FILES["file"]["tmp_name"] = $_FILES["cUplFileFormIKU"]["tmp_name"][$i];
                $_FILES["file"]["error"]    = $_FILES["cUplFileFormIKU"]["error"][$i];
                $_FILES["file"]["size"]     = $_FILES["cUplFileFormIKU"]["size"][$i];
                if ( ! $this->upload->do_upload("file") ){
                    echo('
                        alert("'. $this->upload->display_errors('','') .'") ;
                        bos.tciku_form.obj.find("#idcUplFileFormIKU").html("") ;
                    ') ;
                }else{
                    $data       = $this->upload->data() ;
                    $fname      = "cUplFileFormIKU" . $data['file_ext'] ;
                    $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                    $vFile[$i]  = array( $tname => $data['full_path']) ;
                    savesession($this, "sstciku_form_cUplFileFormIKU", $vFile ) ;
                    echo('
                        //bos.tciku_form.obj.find("#idcUplFileFormIKU").html("") ;
                        //bos.tciku_form.obj.find("#idcUplFileFormIKU").html("<p>Data Uploaded<p>") ;
                    ') ;
                }
            }
        }
    }
}

?>