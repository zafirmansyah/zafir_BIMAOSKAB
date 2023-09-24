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
        $no     = 1;
        while( $dbr = $this->bdb->getrow($dbd) ){
            $vaset   = $dbr ;
            $vaset['Tgl']           = date_2d($dbr['Tgl']) ;
            $vaset['cmdEdit']       = '<button type="button" onClick="bos.tcsurat_masuk.cmdEdit(\''.$dbr['Kode'].'\')"
                                        class="btn btn-success btn-grid">Edit</button>' ;
            $vaset['cmdDelete']     = '<button type="button" onClick="bos.tcsurat_masuk.cmdDelete(\''.$dbr['Kode'].'\')"
                                        class="btn btn-danger btn-grid">Delete</button>' ;
            $vaset['cmdEdit']	   = html_entity_decode($vaset['cmdEdit']) ;
            $vaset['cmdDelete']	= html_entity_decode($vaset['cmdDelete']) ;
            if(getsession($this,"Jabatan") <= "002"){
                $vaset['cmdPrint']    = '<button class="btn btn-info btn-grid '.$no.'" onClick="bos.tcsurat_masuk.cmdPrint(\''.$no.'\',\''.$dbr['Kode'].'\')" title="Show History"> <i class="fa fa-print"></i> Print</button>' ;
                $vaset['cmdPrint']     = html_entity_decode($vaset['cmdPrint']) ;
            }
            
            $vare[]		= $vaset ;
            $no++;
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
        //print_r($va);

        $vaKode         = $va['cKode'];
        $isInsert       = "I" ;
        if($vaKode == "" || trim(empty($vaKode))){
            $cKode = $this->bdb->getKodeSurat() ;
        }else{
            $cKode = $vaKode ;
            $isInsert = "U" ;
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
            // $this->bdb->deleteFile($va) ;
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

        $cUsername     = getsession($this, "username") ;
        $cActivityMenu = "DOKUMEN MASUK" ;
        $cActivityType = ($isInsert == "I") ? "Menyimpan Data Dokumen Masuk dengan Kode Input : " . $cKode : "Merubah Data Dokumen Masuk dengan Kode : " . $cKode ;
        $dtDateTime    = date('Y-m-d H:i:s') ;
        $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;

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
            $lampiran = array();
            $lampiran = $this->bdb->getDataLampiran($cKode);
            $vaFile   = $this->getFileSuratMasuk($cKode);
            unset($lampiran['ID']);
            unset($lampiran['Kode']);
        
            $jsonUnit[] 	= array("id"=>$data['JenisSurat'],"text"=>$data['JenisSurat'] . " - " . $this->bdb->getval("Keterangan", "Kode = '{$data['JenisSurat']}'", "jenis_surat"));
            savesession($this, "ss_suratmasuk_", $cKode) ;
            echo('
                with(bos.tcsurat_masuk.obj){
                    bos.tcsurat_masuk.init() ;     
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
                }
                bos.tcsurat_masuk.gridDisposisi_reload() ;
                bos.tcsurat_masuk.loadFileSuratMasuk('.json_encode($vaFile).');

            ') ;

            //Show data lampiran disposisi            
            foreach($lampiran as $key=>$val){
                if($val == "1"){
                    echo('
                        $("#chck'.$key.'").prop("checked",true);
                    ');
                }
            }
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

            $vaset['cmdDeleteGr'] = '<button type="button" onClick="bos.tcsurat_masuk.gridDisposisi_deleterow('.$n.')" class="btn btn-danger btn-grid">Delete</button>' ;
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

        $cUsername     = getsession($this, "username") ;
        $cActivityMenu = "DOKUMEN MASUK" ;
        $cActivityType = "Menghapus Data Dokumen Surat Masuk Kode " . $va['cKode'] ;
        $dtDateTime    = date('Y-m-d H:i:s') ;
        $this->bdb->insertLogActivity($cUsername, $cActivityMenu, $cActivityType, $dtDateTime) ;

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
        $this->upload->initialize($fcfg);

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
                    bos.tcsurat_masuk.obj.find("#idcUplFile").html("") ;
                ') ;
            }else{
                $data       = $this->upload->data() ;
                $fname      = "cUplFile" . $data['file_ext'] ;
                $tname      = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vFile[$i]  = array( $tname => $data['full_path']) ;
                savesession($this, "sstcmsurat_masuk_cUplFile", $vFile ) ;
                echo('
                    // bos.idcUplFile.obj.find("#idcUplFile").html("") ;
                    // bos.config.obj.find("#idcUplFile").html("<p>Data Uploaded<p>") ;
                ') ;
            }
        }
    }

    public function initReport()
    {
        $cKode = $this->input->post('cKode');
        echo('
            bos.tcsurat_masuk.showSwalInfo("Proses Cetak Lampiran","Lampiran sudah selesai di proses, silahkan download pada url dibawah data table","info") ;
            // alert("'.$cKode.'");
        ');
        $HIS         = date('Ymdhis');
        $pdfFilePath = "./tmp/lksmo_.pdf";
        $cDownloadPath = $pdfFilePath ;
        //load mPDF library
        $this->load->library('m_pdf');

        $dbData = $this->bdb->getDataDetailSuratMasuk($cKode);
        if($dbRow = $this->bdb->getrow($dbData)){
            $cWhereKode         = "Kode = '$cKode'";
            $cTableChk          = "surat_masuk_lampiran_disposisi" ;
            /**
             * 
                
                
                
             * 
             */

            // getval($field, $where, $table)
            
            $optTrue    = "&#9635";
            $optFalse   = "&#9634";

            $chkSegera          = $this->bdb->getval("Segera",$cWhereKode,$cTableChk);
            if($chkSegera){
                $symSegera = $optTrue;
            }else{
                $symSegera = $optFalse;
            }

            $chkSangatSegera    = $this->bdb->getval("SangatSegera",$cWhereKode,$cTableChk);
            if($chkSangatSegera){
                $symSangatSegera = $optTrue;
            }else{
                $symSangatSegera = $optFalse;
            }

            
            $chkTimIR    = $this->bdb->getval("TimIR",$cWhereKode,$cTableChk);
            if($chkTimIR){
                $symTimIR = $optTrue;
            }else{
                $symTimIR = $optFalse;
            }

            
            $chkFungsiDSEK    = $this->bdb->getval("FungsiDSEK",$cWhereKode,$cTableChk);
            if($chkFungsiDSEK){
                $symFungsiDSEK = $optTrue;
            }else{
                $symFungsiDSEK = $optFalse;
            }

            $chkSetuju              = $this->bdb->getval("Setuju",$cWhereKode,$cTableChk);
            if($chkSetuju){
                $symSetuju = $optTrue;
            }else{
                $symSetuju = $optFalse;
            }

            $chkFungsiPPUKS         = $this->bdb->getval("FungsiPPUKS",$cWhereKode,$cTableChk);
            if($chkFungsiPPUKS){
                $symFungsiPPUKS = $optTrue;
            }else{
                $symFungsiPPUKS = $optFalse;
            }

            $chkTolak               = $this->bdb->getval("Tolak",$cWhereKode,$cTableChk);
            if($chkTolak){
                $symTolak = $optTrue;
            }else{
                $symTolak = $optFalse;
            }

            $chkSeksiHumas          = $this->bdb->getval("SeksiHumas",$cWhereKode,$cTableChk);
            if($chkSeksiHumas){
                $symSeksiHumas = $optTrue;
            }else{
                $symSeksiHumas = $optFalse;
            }

            $chkUntukDiteliti       = $this->bdb->getval("UntukDiteliti",$cWhereKode,$cTableChk);
            if($chkUntukDiteliti){
                $symUntukDiteliti = $optTrue;
            }else{
                $symUntukDiteliti = $optFalse;
            }

            $chkTimISPM             = $this->bdb->getval("TimISPM",$cWhereKode,$cTableChk);
            if($chkTimISPM){
                $symTimISPM = $optTrue;
            }else{
                $symTimISPM = $optFalse;
            }

            $chkUnitIPUR            = $this->bdb->getval("UnitIPUR",$cWhereKode,$cTableChk);
            if($chkUnitIPUR){
                $symUnitIPUR = $optTrue;
            }else{
                $symUnitIPUR = $optFalse;
            }

            $chkUntukDiketahui      = $this->bdb->getval("UntukDiketahui",$cWhereKode,$cTableChk);
            if($chkUntukDiketahui){
                $symUntukDiketahui = $optTrue;
            }else{
                $symUntukDiketahui = $optFalse;
            }

            $chkUnitIKSPPUR         = $this->bdb->getval("UnitIKSPPUR",$cWhereKode,$cTableChk);
            if($chkUnitIKSPPUR){
                $symUnitIKSPPUR = $optTrue;
            }else{
                $symUnitIKSPPUR = $optFalse;
            }

            $chkUntukDiselesaikan   = $this->bdb->getval("UntukDiselesaikan",$cWhereKode,$cTableChk);
            if($chkUntukDiselesaikan){
                $symUntukDiselesaikan = $optTrue;
            }else{
                $symUntukDiselesaikan = $optFalse;
            }

            $chkUnitManajemen       = $this->bdb->getval("UnitManajemen",$cWhereKode,$cTableChk);
            if($chkUnitManajemen){
                $symUnitManajemen = $optTrue;
            }else{
                $symUnitManajemen = $optFalse;
            }

            $chkSesuaiCatatan       = $this->bdb->getval("SesuaiCatatan",$cWhereKode,$cTableChk);
            if($chkSesuaiCatatan){
                $symSesuaiCatatan = $optTrue;
            }else{
                $symSesuaiCatatan = $optFalse;
            }

            $chkPM                  = $this->bdb->getval("PM",$cWhereKode,$cTableChk);
            if($chkPM){
                $symPM = $optTrue;
            }else{
                $symPM = $optFalse;
            }

            $chkUntukPerhatian      = $this->bdb->getval("UntukPerhatian",$cWhereKode,$cTableChk);
            if($chkUntukPerhatian){
                $symUntukPerhatian = $optTrue;
            }else{
                $symUntukPerhatian = $optFalse;
            }

            $chkICO                 = $this->bdb->getval("ICO",$cWhereKode,$cTableChk);
            if($chkICO){
                $symICO = $optTrue;
            }else{
                $symICO = $optFalse;
            }

            $chkUntukDiedarkan      = $this->bdb->getval("UntukDiedarkan",$cWhereKode,$cTableChk);
            if($chkUntukDiedarkan){
                $symUntukDiedarkan = $optTrue;
            }else{
                $symUntukDiedarkan = $optFalse;
            }

            $chkKetuaIPEBI          = $this->bdb->getval("KetuaIPEBI",$cWhereKode,$cTableChk);
            if($chkKetuaIPEBI){
                $symKetuaIPEBI = $optTrue;
            }else{
                $symKetuaIPEBI = $optFalse;
            }

            
            $chkUntukDiperbaiki                = $this->bdb->getval("UntukDiperbaiki",$cWhereKode,$cTableChk);
            if($chkUntukDiperbaiki){
                $symUntukDiperbaiki = $optTrue;
            }else{
                $symUntukDiperbaiki = $optFalse;
            }

            $chkUntukDijawab                = $this->bdb->getval("UntukDijawab",$cWhereKode,$cTableChk);
            if($chkUntukDijawab){
                $symUntukDijawab = $optTrue;
            }else{
                $symUntukDijawab = $optFalse;
            }

            $chkUntukDibicarakanDgnSaya     = $this->bdb->getval("UntukDibicarakanDgnSaya",$cWhereKode,$cTableChk);
            if($chkUntukDibicarakanDgnSaya){
                $symUntukDibicarakanDgnSaya = $optTrue;
            }else{
                $symUntukDibicarakanDgnSaya = $optFalse;
            }

            $chkUntukDibicarakanBersama     = $this->bdb->getval("UntukDibicarakanBersama",$cWhereKode,$cTableChk);
            if($chkUntukDibicarakanBersama){
                $symUntukDibicarakanBersama = $optTrue;
            }else{
                $symUntukDibicarakanBersama = $optFalse;
            }

            $chkUntukDiingatkan             = $this->bdb->getval("UntukDiingatkan",$cWhereKode,$cTableChk);
            if($chkUntukDiingatkan){
                $symUntukDiingatkan = $optTrue;
            }else{
                $symUntukDiingatkan = $optFalse;
            }

            $chkUntukDisimpan               = $this->bdb->getval("UntukDisimpan",$cWhereKode,$cTableChk);
            if($chkUntukDisimpan){
                $symUntukDisimpan = $optTrue;
            }else{
                $symUntukDisimpan = $optFalse;
            }

            $chkUntukDisiapkan              = $this->bdb->getval("UntukDisiapkan",$cWhereKode,$cTableChk);
            if($chkUntukDisiapkan){
                $symUntukDisiapkan = $optTrue;
            }else{
                $symUntukDisiapkan = $optFalse;
            }

            $chkUntukDijadwalkan            = $this->bdb->getval("UntukDijadwalkan",$cWhereKode,$cTableChk);
            if($chkUntukDijadwalkan){
                $symUntukDijadwalkan = $optTrue;
            }else{
                $symUntukDijadwalkan = $optFalse;
            }

            $chkUntukDihadiri               = $this->bdb->getval("UntukDihadiri",$cWhereKode,$cTableChk);
            if($chkUntukDihadiri){
                $symUntukDihadiri = $optTrue;
            }else{
                $symUntukDihadiri = $optFalse;
            }


            $htmlHeader = "
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Lembar Disposisi Pejabat Kode ".$cKode."</title>
                        <style>
                            table, th, td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                    </head>
                    <body>
                        <table autosize='1' style='font-size:12px; width: 100%; border: solid 1px;' border='1'>
                            <tr>
                                <td style='width: 50%;' colspan='6'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style='text-align: center;' colspan='6'><h3>LEMBAR DISPOSISI PEJABAT</h3></td>
                            </tr>
                            <tr>
                                <td style='width: 50%;' colspan='6'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style='width: 10%; text-align: center;'><b>No Surat</b></td>
                                <td style='width: 40%;' colspan='2'>".$dbRow['NoSurat']."</td>
                                <td style='width: 50%;' colspan='3'><b>Asal Dokumen</b></td>
                            </tr>
                            <tr>
                                <td style='text-align: center;'><b>Tgl</b></td>
                                <td style='' colspan='2'>".date_2d($dbRow['TglSurat'])."</td>
                                <td style='' colspan='3'>".$dbRow['Dari']."</td>
                            </tr>
                            <!-- tr>
                                <td style='text-align: center'><b>Tgl Terima</b></td>
                                <td style='' colspan='5'>".date_2d($dbRow['Tgl'])."</td>
                            </tr -->
                            <tr>
                                <td style='width: 50%;' colspan='3'><b>Perihal :</b></td>
                                <td style='width: 50%;' colspan='3'><b>Tanggal Terima :</b></td>
                            </tr>
                            <tr>
                                <td colspan='3' style='padding: 15px 8px 15px 8px;'>".$dbRow['Perihal']."</td>
                                <td colspan='3' style='padding: 15px 8px 15px 8px;'>".date_2d($dbRow['Tgl'])."</td>
                            </tr>
                            <tr>
                                <td style='width: 10%; text-align: center;'>".$symSegera."</td>
                                <td style='width: 40%;' colspan='2'><b>Segera</b></td>
                                <td style='width: 10%; text-align: center;'>".$symSangatSegera."</td>
                                <td style='width: 40%;' colspan='2'><b>Sangat Segera</b></td>
                            </tr>
                        </table>
                        
                        <table style='font-size:12px; width: 100%; border: solid 1px;' border='1'>
                            <tr style='height: 60px;'>
                                <td style='width: 100%;' colspan='6'><b>Dari :</b></td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 100%;' colspan='6'><b>DISPOSISI KEPADA :</b></td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%;'>&nbsp;</td>
                                <td style='width: 25%;'><b>Deputi Kepala Perwakilan</b></td>
                                <td style='width: 5%;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%;'>&nbsp;</td>    
                                <td style='width: 25%;'><b>Petunjuk Disposisi</b></td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>".$symTimIR."</td>
                                <td style='width: 25%;'>Tim Implementasi Rekda</td>
                                <td style='width: 5%; text-align: center;'>".$symFungsiDSEK."</td>
                                <td style='width: 25%;'>Fungsi Data & Statistik Ekonomi & Keuangan</td>
                                <td style='width: 5%; text-align: center;'>".$symSetuju."</td>    
                                <td style='width: 25%;'>Setuju</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symFungsiPPUKS."</td>
                                <td style='width: 25%;'>Fungsi Pelaksanaan Pengembangan UMKM, KI, dan Syariah</td>
                                <td style='width: 5%; text-align: center;'>".$symTolak."</td>    
                                <td style='width: 25%;'>Tolak</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symSeksiHumas."</td>
                                <td style='width: 25%;'>Seksi Kehumasan</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiteliti."</td>    
                                <td style='width: 25%;'>Untuk di teliti & pendapat</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>".$symTimISPM."</td>
                                <td style='width: 25%;'>Tim Implementasi SP, PUR, dan MI</td>
                                <td style='width: 5%; text-align: center;'>".$symUnitIPUR."</td>
                                <td style='width: 25%;'>Unit Implementasi PUR</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiketahui."</td>    
                                <td style='width: 25%;'>Untuk diketahui</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUnitIKSPPUR."</td>
                                <td style='width: 25%;'>Unit Implementasi Kebijakan SP dan Pengawasan SP-PUR</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiselesaikan."</td>    
                                <td style='width: 25%;'>Untuk di selesaikan sesuai ketentuan </td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUnitManajemen."</td>
                                <td style='width: 25%;'>Unit Manajemen Intern</td>
                                <td style='width: 5%; text-align: center;'>".$symSesuaiCatatan."</td>    
                                <td style='width: 25%;'>Sesuai Catatan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>".$symPM."</td>
                                <td style='width: 25%;'>PM</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukPerhatian."</td>    
                                <td style='width: 25%;'>Untuk perhatian</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>".$symICO."</td>
                                <td style='width: 25%;'>ICO</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiedarkan."</td>    
                                <td style='width: 25%;'>Untuk diedarkan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>".$symKetuaIPEBI."</td>
                                <td style='width: 25%;'>Ketua IPEBI</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDijawab."</td>    
                                <td style='width: 25%;'>Untuk dijawab</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiperbaiki."</td>    
                                <td style='width: 25%;'>Untuk diperbaiki</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDibicarakanDgnSaya."</td>    
                                <td style='width: 25%;'>Untuk dibicarakan dengan Saya</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDibicarakanBersama."</td>    
                                <td style='width: 25%;'>Untuk dibicarakan bersama</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDiingatkan."</td>    
                                <td style='width: 25%;'>Untuk diingatkan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDisimpan."</td>    
                                <td style='width: 25%;'>Untuk disimpan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDisiapkan."</td>    
                                <td style='width: 25%;'>Untuk disiapkan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDijadwalkan."</td>    
                                <td style='width: 25%;'>Untuk dijadwalkan</td>
                            </tr>
                            <tr style='height: 60px;'>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>&nbsp;</td>
                                <td style='width: 25%;'>&nbsp;</td>
                                <td style='width: 5%; text-align: center;'>".$symUntukDihadiri."</td>    
                                <td style='width: 25%;'>Untuk dihadiri / Wakili</td>
                            </tr>
                        </table>";
            $htmlDispoLevel1Open = "<table style='font-size:12px; width: 100%; border: solid 1px;' border='1'>
                                    <tr style='height: 60px;'>
                                        <td style='width: 100%;' colspan='6'><b>Disposisi Kepala Perwakilan : </b></td>
                                    </tr>
                                "; 
            
            $htmlDispoLevel1Content = " <tr style='padding: 50px 0px 50px 0px'>
                                            <td style='width: 100%; padding: 30px 10px 30px 10px' colspan='6'>
                                            Kepada : 
                                            ";

            $dbDispoLevel1 = $this->bdb->select("surat_masuk_disposisi","Terdisposisi,Deskripsi","Kode = '$cKode' AND LevelDisposisi = '1'") ;
            while($dbRowDispoLevel1 = $this->bdb->getrow($dbDispoLevel1)){
                $numArrayDispoLevel1        = count($dbRowDispoLevel1) ;
                $cTerdisposisi              = $dbRowDispoLevel1['Terdisposisi'];
                $cDeskripsi                 =  $dbRowDispoLevel1['Deskripsi'];
                $cNamaTerdispo              = $this->bdb->getval("fullname", "KodeKaryawan='{$cTerdisposisi}'", "sys_username");
                $htmlIsiDisposisiLevel1[]   = $cNamaTerdispo . " , "; // . " [". $cTerdisposisi ."] , ";
            }
            $htmlIsiDeskripsiDisposisiLevel1   = "<br />" . $cDeskripsi . "<br />";
            

            $htmlDispoLevel1Close = "</td>
                                        </tr>
                                    </table>";
            
            $htmlDispoLevel2Open = "<table style='font-size:12px; width: 100%; border: solid 1px;' border='1'>
                                    <tr style='height: 60px;'>
                                        <td style='width: 100%;' colspan='6'><b>Disposisi Deputi Kepala Perwakilan : </b></td>
                                    </tr>
                                "; 
            
            $htmlDispoLevel2Content = " <tr style='padding: 50px 0px 50px 0px'>
                                            <td style='width: 100%; padding: 30px 10px 30px 10px' colspan='6'>
                                            Kepada : 
                                            ";

            $dbDispoLevel2 = $this->bdb->select("surat_masuk_disposisi","Terdisposisi,Deskripsi","Kode = '$cKode' AND LevelDisposisi = '2'") ;
            while($dbRowDispoLevel2 = $this->bdb->getrow($dbDispoLevel2)){
                $numArrayDispoLevel2            = count($dbRowDispoLevel2) ;
                $cTerdisposisi2                 = $dbRowDispoLevel2['Terdisposisi'];
                $cDeskripsi2                    =  $dbRowDispoLevel2['Deskripsi'];
                $cNamaTerdispo2                 = $this->bdb->getval("fullname", "KodeKaryawan='{$cTerdisposisi2}'", "sys_username");
                $htmlIsiDisposisiLevel2[]       = $cNamaTerdispo2 . " ,"; // . " [". $cTerdisposisi2 ."] , ";
            }
            $htmlIsiDeskripsiDisposisiLevel2   = "<br />" . $cDeskripsi2 . "<br />";
            

            $htmlDispoLevel2Close = "</td>
                                        </tr>
                                    </table>";
            
            $htmlDispoLevel3Open = "<table style='font-size:12px; width: 100%; border: solid 1px;' border='1'>
                                    <tr style='height: 60px;'>
                                        <td style='width: 100%;' colspan='6'><b>Disposisi Kepala Unit : </b></td>
                                    </tr>
                                "; 
            
            $htmlDispoLevel3Content = " <tr style='padding: 50px 0px 50px 0px'>
                                            <td style='width: 100%; padding: 30px 10px 30px 10px' colspan='6'>
                                            Kepada : 
                                            ";

            $dbDispoLevel3 = $this->bdb->select("surat_masuk_disposisi","Terdisposisi,Deskripsi","Kode = '$cKode' AND LevelDisposisi = '3'") ;
            while($dbRowDispoLevel3 = $this->bdb->getrow($dbDispoLevel3)){
                $numArrayDispoLevel3            = count($dbRowDispoLevel3) ;
                $cTerdisposisi3                 = $dbRowDispoLevel3['Terdisposisi'];
                $cDeskripsi3                    = $dbRowDispoLevel3['Deskripsi'];
                $cNamaTerdispo3                 = $this->bdb->getval("fullname", "KodeKaryawan='{$cTerdisposisi3}'", "sys_username");
                $htmlIsiDisposisiLevel3[]       = $cNamaTerdispo3 . " , "; // . " [". $cTerdisposisi3 ."] , ";
            }
            $htmlIsiDeskripsiDisposisiLevel3   = "<br />" . $cDeskripsi3 . "<br />";
            

            $htmlDispoLevel3Close = "</td>
                                        </tr>
                                    </table>";        

            $htmlFooter = "
                    </body>
                </html>
                ";
            $this->m_pdf->pdf->WriteHTML($htmlHeader);
            
            // Level 1
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel1Open);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel1Content);
            for($xx = 0; $xx <= $numArrayDispoLevel1 ; $xx++){
                $this->m_pdf->pdf->WriteHTML($htmlIsiDisposisiLevel1[$xx]);
            }
            $this->m_pdf->pdf->WriteHTML($htmlIsiDeskripsiDisposisiLevel1);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel1Close);
            // Level 1 Close


            // Level 2
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel2Open);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel2Content);
            for($xx = 0; $xx <= $numArrayDispoLevel2 ; $xx++){
                $this->m_pdf->pdf->WriteHTML($htmlIsiDisposisiLevel2[$xx]);
            }
            $this->m_pdf->pdf->WriteHTML($htmlIsiDeskripsiDisposisiLevel2);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel2Close);
            // Level 2 Close

            // Level 3
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel3Open);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel3Content);
            for($xx = 0; $xx <= $numArrayDispoLevel3 ; $xx++){
                $this->m_pdf->pdf->WriteHTML($htmlIsiDisposisiLevel3[$xx]);
            }
            $this->m_pdf->pdf->WriteHTML($htmlIsiDeskripsiDisposisiLevel3);
            $this->m_pdf->pdf->WriteHTML($htmlDispoLevel3Close);
            // Level 3 Close

            $this->m_pdf->pdf->WriteHTML($htmlFooter);
            $this->m_pdf->pdf->Output(FCPATH.$pdfFilePath, "F");
            echo("  
                bos.tcsurat_masuk.obj.find('#downloadLink').html('<a href=".$pdfFilePath." target=`_blank` class=`btn btn-md btn-success`>Download your document here [".$cKode."] </b></a>') ;
            ");
        }
    }

    public function getFileSuratMasuk($cKode)
    {
        $dbData = $this->bdb->getFileSuratMasuk($cKode);
        $vaData = array();
        while($dbr  = $this->bdb->getrow($dbData)){
            $cPathWO     = $dbr['FilePath'];
            $cFileSize   = "0.00";
            $cNamaFileWO = "File Not Found";
            if(file_exists($cPathWO)){
                $nFileSize      = filesize($cPathWO);
                $vaPathWO       = explode("/",$cPathWO);
                $cNamaFileWO    = end($vaPathWO); 
                $cFileSize      = formatSizeUnits($nFileSize);
            }
            $dbr['FileSize'] = $cFileSize;
            $dbr['FileName'] = $cNamaFileWO;
            $vaData[] = $dbr;
        }        
        return $vaData;
    }

    public function deleteFile()
    {
        $va 	= $this->input->post() ;
        $cID    = $va['cID'];
        //echo($cID);
        $this->bdb->deleteFile_perID($cID);

        echo(' 
            Swal.fire({
                icon: "success",
                title: "File Deleted!",
            });

            bos.tcsurat_masuk.init() ;    
        ') ;
    }
}

?>