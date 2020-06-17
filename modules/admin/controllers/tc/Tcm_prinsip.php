<?php

class Tcm_prinsip extends Bismillah_Controller
{
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcm_prinsip_m') ;
        $this->load->helper('bdate') ;		
        $this->load->model('func/func_m') ;

        $this->bdb  = $this->tcm_prinsip_m ;
        $this->func = $this->func_m ;
    }

    public function index(){
        $this->load->view('tc/tcm_prinsip') ;
    }

    public function initForm()
    {
        savesession($this, "sstcm_prinsip_cUplFile" , "") ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset                  = $dbr ;
            $cKodeUnit              = $this->bdb->getval("Unit","username = '{$dbr['UserName']}'","sys_username") ;
            $vaset['Unit']          = $this->bdb->getval("KodeRubrik","Kode = '{$cKodeUnit}'","golongan_unit") ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcm_prinsip.cmdEdit(\''.$dbr['Faktur'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcm_prinsip.cmdDelete(\''.$dbr['Faktur'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	    = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	    = html_entity_decode($vaset['cmdDelete']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function loadGridDataUserDisposisi(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadGridDataUserDisposisi($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Unit']          = $this->bdb->getval("Keterangan", "Kode = '{$dbr['Unit']}'","golongan_unit") ;
            $vaset['cmdPilih']      = '<button type="button" onClick="bos.tcm_prinsip.cmdPilih(\''.$dbr['KodeKaryawan'].'\')"
                                        class="btn btn-success btn-grid">Pilih</button>' ;
            $vaset['cmdPilih']	    = html_entity_decode($vaset['cmdPilih']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
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

    public function selectTargetDisposisi()
    {
        $va 	= $this->input->post() ;
        $cKode 	= $va['kode'] ;
        $data   = $this->bdb->getDataTargetDisposisi($cKode) ;
        if(!empty($data)){
            echo('
            with(bos.tcm_prinsip.obj){
               find("#cKodeKaryawan").val("'.$data['KodeKaryawan'].'") ;
               find("#cDisposisi").val("'.$data['fullname'].'");
               bos.tcm_prinsip.loadModalDisposisi("hide");
            }

         ') ;
        }
    }

    public function validSaving()
    {
        $va         = $this->input->post();
        $lValid     = true ;
        $optMetode  = $va['optMetode'];
        $vaGrid     = json_decode($va['dataDisposisi']);
        if($optMetode == "S"){
            if(!$vaGrid){
                $lValid = false ;
                echo('
                    Swal.fire({
                        icon: "error",
                        title: "Data Tidak Valid" ,
                        text : "Data Pendisposisian Kosong"
                    });   
                ');
            }    
        }
        
        if($lValid){
            $this->saveData($va) ;
        }   
    }

    public function saveData($va)
    {
        $cSifatSurat = $va['optSifatSurat'];
        $nYear       = date('Y') ;
        $nKodeUnit   = getsession($this,'unit') ;

        $cFaktur  = $va['cFaktur'] ;
        if($cFaktur == "" || empty(trim($cFaktur))){
            $cFaktur = $this->bdb->getKodeSurat();
        }
        
        $cNoSurat  = $va['cNoSurat'] ;
        if($cNoSurat == "" || empty(trim($cNoSurat))){
            $cNoSurat   = $this->func->getNomorRubrikSurat($nYear,$nKodeUnit,'M.02',$cSifatSurat,'M02P') ;
        }

        $va['cFaktur']  = $cFaktur ;
        $va['cNoSurat'] = $cNoSurat ;

        $nYear      = date('Y');
        $cKategori  = "/SuratMemorandumM02";
        $adir       = $this->config->item('bcore_uploads_suratbima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
            mkdir($adir,0777,true);
        }

        $upload         = array("cUplFile"=>getsession($this, "sstcm_prinsip_cUplFile")) ;
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

        $save   = $this->bdb->saveData($va) ;

        $optMetode = $va['optMetode'] ;
        if($optMetode == "S"){
            $va['cKodeDispo'] = $this->bdb->getKodeDispoSurat() ;
            $this->bdb->saveDataDisposisi($va) ;
        }
        if($save){
            echo('
                bos.tcm_prinsip.initForm() ;
                bos.tcm_prinsip.grid1_reloaddata() ;
                bos.tcm_prinsip.initTab1() ;
                Swal.fire({
                    icon: "success",
                    title: "'.$va['cNoSurat'].'",
                    html: "Nomor Surat <b> M.02 Persetujuan Prinsip </b> Sebagai Berikut"
                });   
            ');
        }
    }

    public function savingFile()
    {
        savesession($this, "sstcm_prinsip_cUplFile" , "") ;
        $cFileName = "SuratMasuk_". date("Ymd_His");
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
                    bos.tcm_prinsip.obj.find("#idcUplFile").html("") ;
                ') ;
            }else{
                $data       = $this->upload->data() ;
                $fname      = "cUplFile" . $data['file_ext'] ;
                $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vFile[$i]  = array( $tname => $data['full_path']) ;
                savesession($this, "sstcm_prinsip_cUplFile", $vFile ) ;
                echo('
                    //bos.tcm_prinsip.obj.find("#idcUplFile").html("") ;
                    //bos.config.obj.find("#idcUplFile").html("<p>Data Uploaded<p>") ;
                ') ;
            }
        }
    }

    public function editing()
    {
        $va         = $this->input->post() ;
        $cFaktur 	= $va['cFaktur'] ;
        $data       = $this->bdb->getDataDetail($cFaktur) ;
        if(!empty($data)){
            $cMetodeDisposisi           = $data['MetodeDisposisi'] ;
            $jsonSifatSurat[]           = array("id"=>$data['Sifat'],"text"=>$data['Sifat']." - " . $this->bdb->getval("Keterangan","Kode = '{$data['Sifat']}'","jenis_sifat_surat")) ;
            echo('
                with(bos.tcm_prinsip.obj){
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    $("#cFaktur").val("'.$data['Faktur'].'") ;
                    $("#cNoSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#cSubject").val("'.$data['Perihal'].'") ;
                    $("#optSifatSurat").sval('.json_encode($jsonSifatSurat).');

                }
                bos.tcm_prinsip.setContentJS(\''.$data['Deskripsi'].'\') ;
                bos.tcm_prinsip.setopt("optMetode","'.$cMetodeDisposisi.'");
            ') ;
        }
    }

    public function deletePrinsip()
    {
        $id = $this->input->post('cFaktur') ;
        $this->bdb->deletePrinsip($id) ;
    }
}


?>