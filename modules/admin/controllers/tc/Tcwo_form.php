<?php 

/**
 * 
 */
class Tcwo_form extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcwo_form_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcwo_form_m ;
    }

    public function index(){
        $this->load->view('tc/tcwo_form') ;
    }

    public function loadgrid(){
        $cUserName  = getsession($this,"username");
        $va         = json_decode($this->input->post('request'), true) ;
        $vare       = array() ;
        $vdb        = $this->bdb->loadgrid($va) ;
        $dbd        = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $lStatus                = $dbr['Status'];
            $cStatus                = "<span class='text-default'>New<span>";
            $btnClass               = "btn-default";
            if($lStatus == "1"){ //proses
                $btnClass = "btn-success";
                $cStatus  = "<span class='text-success'>Proses<span>";
            }else if($lStatus == "2"){ //pending
                $btnClass = "btn-info";
                $cStatus  = "<span class='text-info'>Pending<span>";
            }else if($lStatus == "3"){ // reject
                $btnClass = "btn-danger";                
                $cStatus  = "<span class='text-danger'>Reject<span>";
            }
            $vaset                  = $dbr ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdDetail']     = '<button class="btn '.$btnClass.' btn-lg btn-icon" onClick="bos.tcwo_form.cmdStartWO(\''.$dbr['Kode'].'\')" title="Ambil"><i class="fa fa-pencil"></i></button>' ;
            
            if($dbr['TujuanUserName'] <> $cUserName){ //filter ini untuk tombol yg tampil di admin
                $vaset['cmdDetail']     = '<button class="btn '.$btnClass.' btn-lg btn-icon" onClick="alert(\'Anda tidak bisa mengambil pekerjaan ini!\');"><i class="fa fa-pencil"></i></button>' ;
            }

            $vdb2     = $this->bdb->getDataOnProsesWO($dbr['Kode']); // ambil data WO jika WO ini yang sudah dikerjakan
            $dbd2     = $vdb2['db'];
            $cFaktur  = "";
            $cUserYgAmbilWO = "";
            if($dbr2  = $this->bdb->getrow($dbd2)){
                $cFaktur = $dbr2['Faktur'];
                $cUserYgAmbilWO = $dbr2['UserName'];
            }
            
            if($lStatus == "1"){    // cek jika on proses
                $vaset['cmdDetail']     = '<button class="btn '.$btnClass.' btn-lg btn-icon" onClick="bos.tcwo_form.cmdContinueWO(\''.$cFaktur.'\')" title="Lanjutkan WO?"><i class="fa fa-pencil"></i></button>' ; //parameter diisi faktur supaya memudahkan filter untuk melanjutkan WO
                if($dbr['TujuanUserName'] <> $cUserName){ //filter ini untuk tombol yg tampil di admin jika on proses
                    $vaset['cmdDetail']     = '<button class="btn '.$btnClass.' btn-lg btn-icon" onClick="alert(\'Pekerjaan sudah diambil oleh '.$cUserYgAmbilWO.'!\');"><i class="fa fa-pencil"></i></button>' ;
                }
            }
            $vaset['cmdDetail']     .= '&nbsp;&nbsp;';
            $vaset['cmdDetail']	    = html_entity_decode($vaset['cmdDetail']) ;
            $vaset['Status']        = html_entity_decode($cStatus);

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }


    public function init(){
        savesession($this, "ss_womaster_", "") ;
        savesession($this, "sstcmwo_master_cUplFileFormWO", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        
        //print_r($va);
        $cKode         = $va['cKode'];
        
        $nYear      = date('Y');
        $cKategori  = "/WO-FORM";
        $adir       = $this->config->item('bcore_uploads_wobima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
             mkdir($adir,0777,true);
            echo('
                bos.tcwo_form.init() ; 
                Swal.fire({
                    icon: "warning",
                    title: "Hallo, bisa mkdir gak ya?"
                });   
            ');
        }

        $upload         = array("cUplFileFormWO"=>getsession($this, "sstcwo_form_cUplFileFormWO")) ;
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
        savesession($this, "sstcwo_form_cUplFileFormWO" , "") ;
        $saving = $this->bdb->saving($va) ;

        echo(' 
            Swal.fire({
                icon: "success",
                title: "Data Saved!",
            });
            bos.tcwo_form.init() ;     
        ') ;
    }

    public function startWO(){
        $va 	    = $this->input->post() ;
        //var_dump($va);
        if(!isset($va['cFaktur'])){
            $cKode 	    = $va['cKode'] ;
            $cFaktur    = $this->bdb->getFakturFormWO() ;
        }else{
            $cFaktur    = $va['cFaktur'];
            $cKode      = $this->bdb->getKodeWObyFaktur($cFaktur);
        }
        //var_dump($cKode);
        $data       = $this->bdb->getdataWO($cKode) ;    
        if(!empty($data)){
            savesession($this, "ss_tcwo_form_", $cKode) ;
            if(!isset($va['cFaktur'])){
                $this->bdb->startWO($cKode,$cFaktur);
            }
            echo('
                with(bos.tcwo_form.obj){
                    $("#cKode").val("'.$cKode.'") ;
                    $("#cFaktur").val("'.$cFaktur.'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                }
            ');
        }
    }

    public function seekKodeWO()
    {
        $search     = $this->input->get('q');
        $vdb        = $this->bdb->seekKodeWO($search) ;
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
        savesession($this, "sstcwo_form_cUplFileFormWO" , "") ;
        $cFileName = "WO_". date("Ymd_His");
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"*","overwrite"=>true) ;
                
        $this->load->library('upload', $fcfg) ;
        $nTotalFile = count($_FILES['cUplFileFormWO']['name']);
        if($nTotalFile > 0){
            for($i = 0; $i < $nTotalFile; $i++){
                $_FILES["file"]["name"]     = $cFileName.$_FILES["cUplFileFormWO"]["name"][$i];
                $_FILES["file"]["type"]     = $_FILES["cUplFileFormWO"]["type"][$i];
                $_FILES["file"]["tmp_name"] = $_FILES["cUplFileFormWO"]["tmp_name"][$i];
                $_FILES["file"]["error"]    = $_FILES["cUplFileFormWO"]["error"][$i];
                $_FILES["file"]["size"]     = $_FILES["cUplFileFormWO"]["size"][$i];
                if ( ! $this->upload->do_upload("file") ){
                    echo('
                        alert("'. $this->upload->display_errors('','') .'") ;
                        bos.tcwo_form.obj.find("#idcUplFileFormWO").html("") ;
                    ') ;
                }else{
                    $data       = $this->upload->data() ;
                    $fname      = "cUplFileFormWO" . $data['file_ext'] ;
                    $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                    $vFile[$i]  = array( $tname => $data['full_path']) ;
                    savesession($this, "sstcwo_form_cUplFileFormWO", $vFile ) ;
                    echo('
                        //bos.tcwo_form.obj.find("#idcUplFileFormWO").html("") ;
                        //bos.tcwo_form.obj.find("#idcUplFileFormWO").html("<p>Data Uploaded<p>") ;
                    ') ;
                }
            }
        }
    }
}

?>