<?php 

/**
 * 
 */
class Tcwo_master extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcwo_master_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcwo_master_m ;
    }

    public function index(){
        $this->load->view('tc/tcwo_master') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $lStatus                = $dbr['Status'];
            $cStatus                = "<span class='text-default'>New<span>";
            $btnClass               = "btn-default";
            if($lStatus == "1"){ //proses
                $cStatus  = "<span class='text-success'>Proses<span>";
            }else if($lStatus == "2"){ //pending
                $cStatus  = "<span class='text-info'>Pending<span>";
            }else if($lStatus == "3"){ // reject
                $cStatus  = "<span class='text-danger'>Reject<span>";
            }else if($lStatus == "F"){ // finish
                $cStatus  = "<span class='text-warning'>Finish<span>";
            }
            
            $vaset   = $dbr ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['Status']        = html_entity_decode($cStatus);
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcwo_master.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcwo_master.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	   = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	= html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }


    public function init(){
        savesession($this, "ss_womaster_", "") ;
        savesession($this, "sstcmwo_master_cUplFileWO", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        
        $vaKode     = $va['cKode'];
        if($vaKode == "" || trim(empty($vaKode))){
            $cKode = $this->bdb->getKodeWO() ;
            $cStatusWO  = "0";
        }else{
            $cKode = $vaKode ;
            $cStatusWO  = $va['cStatus'];
        }

        $va['cKode']  = $cKode ;
        $va['cStatus'] = $cStatusWO;
        $nYear      = date('Y');
        $cKategori  = "/WO";
        $adir       = $this->config->item('bcore_uploads_wobima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
             mkdir($adir,0777,true);
            echo('
                bos.tcwo_master.init() ; 
                Swal.fire({
                    icon: "warning",
                    title: "Hallo, bisa mkdir gak ya?"
                });   
            ');
        }

        $upload         = array("cUplFileWO"=>getsession($this, "sstcwo_master_cUplFileWO")) ;
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
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
            });
            bos.tcwo_master.init() ;     
        ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            $jsonUnit[] 	= array("id"=>$data['TujuanUserName'],"text"=>$data['TujuanUserName'] . " - " . $this->bdb->getval("fullname", "username = '{$data['TujuanUserName']}'", "sys_username"));
            savesession($this, "ss_tcwo_master_", $cKode) ;
            echo('
                with(bos.tcwo_master.obj){
                    find("#cKode").val("'.$data['Kode'].'") ;
                    find("#cSubject").val("'.$data['Subject'].'") ;
                    tinymce.activeEditor.setContent(`'.$data['Deskripsi'].'`);
                    find("#optUserName").sval('.json_encode($jsonUnit).') ;
                    find("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    find("#cStatus").val("'.$data['Status'].'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                }
            ') ;
        }
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->bdb->deleting($va['cKode']) ;
        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Deleted!",
            });
            bos.tcwo_master.grid1_reloaddata() ; 
            bos.tcwo_master.grid1_reload() ; 
        ') ;
    }

    public function seekUserName()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekUserName($search) ;
        $dbd        = $vdb['db'];
        $vare       = array();
        while($dbr  = $this->bdb->getrow($dbd)){
            $vare[] = array("id"=>$dbr['username'], "text"=>$dbr['username'] . " - ". $dbr['fullname']) ;
        }
        $Result = json_encode($vare);
        echo($Result);
    }

    public function savingFile()
    {
        savesession($this, "sstcwo_master_cUplFileWO" , "") ;
        $cFileName = "WO_". date("Ymd_His");
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"*","overwrite"=>true) ;
                
        $this->load->library('upload', $fcfg) ;
        $nTotalFile = count($_FILES['cUplFileWO']['name']);
        if($nTotalFile > 0){
            for($i = 0; $i < $nTotalFile; $i++){
                $_FILES["file"]["name"]     = $cFileName.$_FILES["cUplFileWO"]["name"][$i];
                $_FILES["file"]["type"]     = $_FILES["cUplFileWO"]["type"][$i];
                $_FILES["file"]["tmp_name"] = $_FILES["cUplFileWO"]["tmp_name"][$i];
                $_FILES["file"]["error"]    = $_FILES["cUplFileWO"]["error"][$i];
                $_FILES["file"]["size"]     = $_FILES["cUplFileWO"]["size"][$i];
                if ( ! $this->upload->do_upload("file") ){
                    echo('
                        alert("'. $this->upload->display_errors('','') .'") ;
                        bos.tcwo_master.obj.find("#idcUplFileWO").html("") ;
                    ') ;
                }else{
                    $data       = $this->upload->data() ;
                    $fname      = "cUplFileWO" . $data['file_ext'] ;
                    $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                    $vFile[$i]  = array( $tname => $data['full_path']) ;
                    savesession($this, "sstcwo_master_cUplFileWO", $vFile ) ;
                    echo('
                        //bos.tcwo_master.obj.find("#idcUplFileWO").html("") ;
                        //bos.tcwo_master.obj.find("#idcUplFileWO").html("<p>Data Uploaded<p>") ;
                    ') ;
                }
            }
        }
    }
    /*
    Kode Status WO
    0 = new
    1 = start / proses
    2 = pending
    3 = reject
    F = finish
    D = delete
    */
}

?>