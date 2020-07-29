<?php 

/**
 * 
 */
class Tcsurat_masuk extends Bismillah_Controller
{
        
    public function __construct(){
        parent::__construct() ;
        $this->load->model('tc/tcsurat_masuk_m') ;
        $this->load->helper('bdate') ;

        $this->bdb = $this->tcsurat_masuk_m ;
    }

    public function index(){
        $this->load->view('tc/tcsurat_masuk') ;
    }

    public function loadgrid(){
        $va     = json_decode($this->input->post('request'), true) ;
        $vare   = array() ;
        $vdb    = $this->bdb->loadgrid($va) ;
        $dbd    = $vdb['db'] ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcsurat_masuk.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcsurat_masuk.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	   = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	= html_entity_decode($vaset['cmdDelete']) ;

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
            $vaset['cmdPilih']      = '<button type="button" onClick="bos.tcsurat_masuk.cmdPilih(\''.$dbr['KodeKaryawan'].'\')"
                                        class="btn btn-success btn-grid">Pilih</button>' ;
            $vaset['cmdPilih']	    = html_entity_decode($vaset['cmdPilih']) ;

            $vare[]		= $vaset ;
        }

        $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
        echo(json_encode($vare)) ;
    }

    public function init(){
        savesession($this, "ss_suratmasuk_", "") ;
        savesession($this, "sstcmsurat_masuk_cUplFile", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        
        $vaKode         = $va['cKode'];
        if($vaKode == "" || trim(empty($vaKode))){
            $cKode = $this->bdb->getKodeSurat() ;
        }else{
            $cKode = $vaKode ;
        }

        $va['cKode'] = $cKode ;

        $nYear      = date('Y');
        $cKategori  = "/SuratMasuk";
        $adir       = $this->config->item('bcore_uploads_suratbima') . $nYear . $cKategori ;
        if(!is_dir($adir)){
            mkdir($adir,0777,true);
        }

        $upload         = array("cUplFile"=>getsession($this, "sstcmsurat_masuk_cUplFile")) ;
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
            bos.tcsurat_masuk.init() ;     
        ') ;
    }

    public function editing(){
        $va 	    = $this->input->post() ;
        $cKode 	    = $va['cKode'] ;
        $data       = $this->bdb->getdata($cKode) ;
        if(!empty($data)){
            $jsonUnit[] 	= array("id"=>$data['JenisSurat'],"text"=>$data['JenisSurat'] . " - " . $this->bdb->getval("Keterangan", "Kode = '{$data['JenisSurat']}'", "jenis_surat"));
            savesession($this, "ss_suratmasuk_", $cKode) ;
            echo('
                with(bos.tcsurat_masuk.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSuratDari").val("'.$data['Dari'].'") ;
                    $("#optJenisSurat").sval('.json_encode($jsonUnit).') ;
                    $("#cPerihal").val("'.$data['Perihal'].'") ;
                    $("#cNomorSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#dTglSurat").val("'.date_2d($data['TglSurat']).'") ;
                    tinymce.activeEditor.setContent("'.$data['Deskripsi'].'");
                    $("#cLastPath").val("'.$data['Path'].'") ;
                    find(".nav-tabs li:eq(1) a").tab("show") ;
                    bos.tcsurat_masuk.gridDisposisi_reload() ;
                }
            ') ;
        }
                    
        // Show Data Grid Disposisi
        $vare = array();
        $n = 0 ;
        $dbd = $this->bdb->getDataDisposisi($cKode) ;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $n++;
            // $vaset          = $dbr ;
            $vaset['recid']      = $n;
            $cNamaDisposisi      = $this->bdb->getval("fullname", "KodeKaryawan = '{$dbr['Terdisposisi']}'","sys_username") ;
            $vaset['level']      = $dbr['Level'] ;
            $vaset['kode']       = $dbr['Terdisposisi'] ;
            $vaset['disposisi']  = $cNamaDisposisi ;

            $vaset['cmdDeleteGr'] = '<button type="button" onClick="bos.tcsurat_masuk.gridDisposisi_deleterow('.$n.')"
                                    class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdDeleteGr']	= html_entity_decode($vaset['cmdDeleteGr']) ;
            $vare[]             = $vaset ;
        }
        $vare = json_encode($vare);
        echo('
            w2ui["bos-form-tcsurat_masuk_gridDisposisi"].add('.$vare.');
            bos.tcsurat_masuk.initDetail();
        ');
    }

    public function deleting(){
        $va 	= $this->input->post() ;
        $this->bdb->deleting($va['cKode']) ;
        echo(' 
            bos.tcsurat_masuk.grid1_reloaddata() ; 
            bos.tcsurat_masuk.grid1_reload() ; 
        ') ;
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

    public function selectTargetDisposisi()
    {
        $va 	= $this->input->post() ;
        $cKode 	= $va['kode'] ;
        $data   = $this->bdb->getDataTargetDisposisi($cKode) ;
        if(!empty($data)){
            echo('
            with(bos.tcsurat_masuk.obj){
               find("#cKodeKaryawan").val("'.$data['KodeKaryawan'].'") ;
               find("#cDisposisi").val("'.$data['fullname'].'");
               bos.tcsurat_masuk.loadModalDisposisi("hide");
            }

         ') ;
        }
    }

    public function savingFile()
    {
        savesession($this, "sstcmsurat_masuk_cUplFile" , "") ;
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
                    bos.tcmsurat_masuk.obj.find("#idcUplFile").html("") ;
                ') ;
            }else{
                $data       = $this->upload->data() ;
                $fname      = "cUplFile" . $data['file_ext'] ;
                $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vFile[$i]  = array( $tname => $data['full_path']) ;
                savesession($this, "sstcmsurat_masuk_cUplFile", $vFile ) ;
                echo('
                    //bos.tcmsurat_masuk.obj.find("#idcUplFile").html("") ;
                    //bos.config.obj.find("#idcUplFile").html("<p>Data Uploaded<p>") ;
                ') ;
            }
        }
    }

    
}

?>