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
        savesession($this, "ssmstsurat_cUplFile", "") ;
    }

    public function saving(){
        $va 	    = $this->input->post() ;
        $nYear      = date('Y');
        $cKategori  = "/SuratMasuk";
        $adir       = $this->config->item('bcore_uploads_suratbima') ; // . $nYear . $cKategori ;
        // echo('alert("'.$adir.'");');
        if(!is_dir($adir)){
            mkdir($adir,0777);
            echo('
                bos.tcsurat_masuk.init() ; 
                Swal.fire({
                    icon: "warning",
                    title: "Hallo, bisa mkdir gak ya?"
                });   
            ');
        }

        $upload = array("cUplFile"=>getsession($this, "ssmstsurat_cUplFile")) ;
        $va['FilePath'] = ""; 
        $dir = "" ;
        foreach ($upload as $key => $value) {
            if($value !== ""){
                $value  = json_decode($value, true) ;
                foreach ($value as $tkey => $file) {
                    $vi     = pathinfo($file) ;
                    $dir    = $adir.'/' ;
                    $dir   .=  $vi['filename'] . "." . $vi['extension'] ;
                    if(is_file($dir)) @unlink($dir) ;
                    if(@copy($file,$dir)){
                        // @unlink($file) ;
                        // @unlink($this->bdb->getconfig($key)) ;
                        $this->bdb->saveconfig($key, $dir) ;
                    }
                }
            }
        }
        $va['FilePath'] = $dir ;

        $saving     = $this->bdb->saving($va) ;
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
            savesession($this, "ss_suratmasuk_", $cKode) ;
            echo('
                with(bos.tcsurat_masuk.obj){
                    $("#cKode").val("'.$data['Kode'].'") ;
                    $("#cSuratDari").val("'.$data['Dari'].'") ;
                    $("#cPerihal").val("'.$data['Perihal'].'") ;
                    $("#cNomorSurat").val("'.$data['NoSurat'].'") ;
                    $("#dTgl").val("'.date_2d($data['Tgl']).'") ;
                    $("#dTglSurat").val("'.date_2d($data['TglSurat']).'") ;
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

    public function savingFile($cfg)
    {
        savesession($this, "ssmstsurat_" . $cfg, "") ;
        // echo('alert("'.$cfg.'");');
        $cFileName = $cfg ."_". date("Ymd_His");
        $fcfg   = array("upload_path"=>"./tmp/","allowed_types"=>"pdf","overwrite"=>true,
                        "file_name"=> $cFileName ) ;
        $this->load->library('upload', $fcfg) ;

        if ( ! $this->upload->do_upload(0) ){
            echo('
                alert("'. $this->upload->display_errors('','') .'") ;
                bos.mstsurat.obj.find("#idl'.$cfg.'").html("") ;
            ') ;
        }else{
            $data   = $this->upload->data() ;
            $fname  = $cfg . $data['file_ext'] ;
            $tname  = str_replace($data['file_ext'], "", $data['client_name']) ;
            $vFile  = array( $tname => $data['full_path']) ;
            savesession($this, "ssmstsurat_" . $cfg, json_encode($vFile) ) ;
            echo('
                bos.mstsurat.obj.find("#idl'.$cfg.'").html("") ;
                bos.config.obj.find("#idcUplFile").html("<p>Data Uploaded<p>") ;
            ') ;
        }
    }


}

?>