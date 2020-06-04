<?php

    class mstregisterkaryawan extends CI_Controller
    {
        protected $bdb ;
        public function __construct(){
            parent::__construct() ;
            $this->load->helper("bdate") ;
            $this->load->model("pim/mstregisterkaryawan_m") ;
            $this->bdb 	= $this->mstregisterkaryawan_m ;
        }

        public function index(){
            savesession($this, "ssidKota_" , "") ;
            savesession($this, "ssidKecamatan_" , "") ;
            savesession($this, "ssusername_image", "") ;
            $cBranch 	= getsession($this, "cabang") ;
            $cKodeMO 	= getsession($this, "KodeMO") ;
            $valIndex   = array("chKodeCabang"=>$cBranch,
                                "chKodeMO"=>$cKodeMO
                                );
            $this->load->view("pim/mstregisterkaryawan",$valIndex) ;
        } 

        public function loadgrid(){
            $va     = json_decode($this->input->post('request'), true) ;
            $vare   = array() ;
            $vdb    = $this->mstregisterkaryawan_m->loadgrid($va) ;
            $dbd    = $vdb['db'] ;
            while( $dbr = $this->mstregisterkaryawan_m->getrow($dbd) ){
               $vaset   = $dbr ;
               $vaset['cmdedit']    = '<button type="button" onClick="bos.mstregisterkaryawan.cmdedit(\''.$dbr['Kode'].'\')"
                                 class="btn btn-success btn-grid">Edit</button>' ;
               $vaset['cmddelete']  = '<button type="button" onClick="bos.mstregisterkaryawan.cmddelete(\''.$dbr['Kode'].'\')"
                                 class="btn btn-danger btn-grid">Delete</button>' ;
               $vaset['cmdedit']	   = html_entity_decode($vaset['cmdedit']) ;
               $vaset['cmddelete']	= html_entity_decode($vaset['cmddelete']) ;
      
               $vare[]		= $vaset ;
            }
      
            $vare 	= array("total"=>$vdb['rows'], "records"=>$vare ) ;
            echo(json_encode($vare)) ;
         }
      
         public function init(){
            savesession($this, "sscabang_kode", "") ;
            savesession($this, "ssidKota_", "") ;
            savesession($this, "ssidKecamatan_", "") ;
         }

        public function getCIFCode()
        {
            $cCIF  = $this->bdb->getCIFCode() ;
            $vaCIF = explode(".",$cCIF);
            echo('
                $("#cCabang").val("'.$vaCIF[0].'") ;
                $("#cUrut").val("'.$vaCIF[2].'") ;
                
                $("#cCIF").val("'.$cCIF.'") ;
                $("#cCabang").prop("readonly","readonly") ;
                $("#cUrut").prop("readonly","readonly") ;
            ') ;
        }

        public function ValidSaving()
        {
            $va             = $this->input->post() ;
            // $va['dDate']    = date_2d($va['dDate']) ;
            $boolValid      = true ;
            $cErrAlert          = "" ;
            $cErrAlert          .= "!!! WARNING !!! \\n" ;
            
            $cNama = $va['cNama'] ;
            // echo('alert("'.$cNama.'");');
            if(empty($cNama) || trim($cNama) == ""){ 
                $boolValid = false ;
                $cErrAlert .= "Nama tidak boleh kosong ! \\n" ;
            }

            if(empty($va['cAlamatKTP']) || trim($va['cAlamatKTP'] == "")){
                $boolValid = false ;
                $cErrAlert .= "Alamat KTP Nasabah Tidak Boleh Kosong ! \\n" ;
            }

            if(empty($va['cAlamat']) || trim($va['cAlamat'] == "")){
                $boolValid = false ;
                $cErrAlert .= "Alamat Tinggal Nasabah Tidak Boleh Kosong ! \\n" ;
            }


            $cIDCard = $va['cIDCard'];
            if($cIDCard == ""){
                $boolValid = false ;
                $cErrAlert .= "ID Card tidak boleh kosong! \\n" ;
            }

            if($boolValid){

                if(!isset($va['optKotaTinggal']) || is_null($va['optKotaTinggal'])){
                    $va['optKotaTinggal'] = "" ;
                }
                if(!isset($va['optKota']) || is_null($va['optKota'])){
                    $va['optKota'] = "" ;
                }
                

                if(!isset($va['optKelurahanTinggal']) || is_null($va['optKelurahanTinggal'])){
                    $va['optKelurahanTinggal'] = "" ;
                }
                if(!isset($va['optKelurahan']) || is_null($va['optKelurahan'])){
                    $va['optKelurahan'] = "" ;
                }
                

                if(!isset($va['optKecamatanTinggal']) || is_null($va['optKecamatanTinggal'])){
                    $va['optKecamatanTinggal'] = "" ;
                }
                if(!isset($va['optKecamatan']) || is_null($va['optKecamatan'])){
                    $va['optKecamatan'] = "" ;
                }
            
                if(!isset($va['optPendidikan']) || is_null($va['optPendidikan'])){
                    $va['optPendidikan'] = "" ;
                }

                $this->Saving($va);
                echo(' 
                    alert("Data Saved!") ;  
                ') ;
            }else{
                echo(' 
                    bos.mstregisterkaryawan.errAlert("'.$cErrAlert.'") ;  
                ') ;
            }

        }

        public function SeekDataDetail()
        {
            $va             = $this->input->post() ;
            // $lPar           = $va['cHiddenPar'];
            $cCIF           = $va['cCIF'];
            $vaData         = $this->bdb->SeekDataDetail($cCIF);
            $image          = "" ;
            $imageMapsUsaha = "" ;

            if(!empty($vaData)){
                savesession($this, "sstcrekapproposal_id", $vaData['Kode']) ;
                $jsonKotaTinggal[]          = array("id"=>$vaData['KotaTinggal'],"text"=>$vaData['KotaTinggal']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['KotaTinggal']}'","kota")) ;
                $jsonKecamatanTinggal[]     = array("id"=>$vaData['KecamatanTinggal'],"text"=>$vaData['KecamatanTinggal']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['KecamatanTinggal']}'","kecamatan")) ;
                $jsonKelurahanTinggal[]     = array("id"=>$vaData['KelurahanTinggal'],"text"=>$vaData['KelurahanTinggal']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['KelurahanTinggal']}'","kelurahan")) ;
                $jsonKota[]                 = array("id"=>$vaData['Kota'],"text"=>$vaData['Kota']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['Kota']}'","kota")) ;
                $jsonKecamatan[]            = array("id"=>$vaData['Kecamatan'],"text"=>$vaData['Kecamatan']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['Kecamatan']}'","kecamatan")) ;
                $jsonKelurahan[]            = array("id"=>$vaData['Kelurahan'],"text"=>$vaData['Kelurahan']. "-" . $this->bdb->getval("Keterangan","Kode = '{$vaData['Kelurahan']}'","kelurahan")) ;
                $jsonPendidikanTerakhir[]   = array("id"=>$vaData['PendidikanTerakhir'],"text"=>$vaData['PendidikanTerakhir']." - " . $this->bdb->getval("Keterangan","Kode = '{$vaData['PendidikanTerakhir']}'","pendidikan")) ;
                
                $img_map_rumah   = ($vaData['img_map_rumah'] !== "") ? json_decode($vaData['img_map_rumah'], true) : array() ;
                if(isset($img_map_rumah['maps_rumah'])){
                    $image  = '<img src=\"'.base_url($img_map_rumah['maps_rumah']).'\" class=\"img-responsive\"/>' ;
                }

                $img_map_usaha   = ($vaData['img_map_usaha'] !== "") ? json_decode($vaData['img_map_usaha'], true) : array() ;
                if(isset($img_map_usaha['maps_usaha'])){
                    $imageMapsUsaha  = '<img src=\"'.base_url($img_map_usaha['maps_usaha']).'\" class=\"img-responsive\"/>' ;
                }

                echo('
                    with(bos.mstregisterkaryawan.obj){
                        find("#cKode").val("'.$cCIF.'");
                        find("#cNama").val("'.$vaData['Nama'].'");
                        find("#cAlamatKTP").val("'.$vaData['AlamatKTP'].'");
                        find("#cAlamat").val("'.$vaData['AlamatTinggal'].'");
                        find("#cKodePos").val("'.$vaData['KodePosTinggal'].'");
                        find("#cIDCard").val("'.$vaData['NoKTP'].'");
                        find("#cNPWP").val("'.$vaData['NoNPWP'].'");
                        find("#dTglLahir").val("'.date_2d($vaData['TglLahir']).'");
                        find("#cTempatLahir").val("'.$vaData['TempatLahir'].'");
                        find("#cNoTelepon").val("'.$vaData['NoTelepon'].'");
                        find("#cNoHandphone").val("'.$vaData['NoHandphone'].'");
                        
                        find("#optPendidikan").sval('.json_encode($jsonPendidikanTerakhir).');
                        find("#optKota").sval('.json_encode($jsonKotaTinggal).');
                        find("#optKecamatan").sval('.json_encode($jsonKecamatanTinggal).');
                        find("#optKelurahan").sval('.json_encode($jsonKelurahanTinggal).');
                        find("#optKotaKTP").sval('.json_encode($jsonKota).');
                        find("#optKecamatanKTP").sval('.json_encode($jsonKecamatan).');
                        find("#optKelurahanKTP").sval('.json_encode($jsonKelurahan).');
                        
                    }
                ') ;
                // find("#idimage").html("'.$image.'") ;
                // find("#idimage_maps_usaha").html("'.$imageMapsUsaha.'") ;
                // find("#chimgRumah").val(`'.$vaData['img_map_rumah'].'`) ; 
                // find("#chimgUsaha").val(`'.$vaData['img_map_usaha'].'`) ; 
                
            }else{
                echo('
                    bos.mstregisterkaryawan.errAlert("'.$cCIF.'") ;   
                    bos.mstregisterkaryawan.errAlert("Sorry, We Can Not Fetch This Code!") ;  
                ') ;
            }
        }

        public function Saving($va=array())
        {
            return $this->bdb->saving($va) ;
        }

        public function SetSessionKota()
        {
            $idKota = $this->input->post('idKota') ;
            $cKey = "ssidKota_" ;
            savesession($this, $cKey , $idKota) ;
        }

        public function SetSessionKecamatan()
        {
            $idKecamatan = $this->input->post('idKecamatan') ;
            $cKey = "ssidKecamatan_" ;
            savesession($this, $cKey , $idKecamatan) ;
        }

        public function SeekPendidikan(){
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekPendidikan($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekKota()
        {
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekKota($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekKecamatan()
        {
            
            $cKota = getsession($this, "ssidKota_") ;
            
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekKecamatan($search,$cKota) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekKelurahan()
        {

            $cKota      = getsession($this, "ssidKota_") ;
            $cKecamatan = getsession($this, "ssidKecamatan_") ;

            $cLocation  = $cKecamatan ;

            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekKelurahan($search,$cLocation) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekJenisIzinUsaha()
        {
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekJenisIzinUsaha($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekBadanHukumUsaha()
        {
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekBentukBadanUsaha($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekBidangUsaha($value='')
        {
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekBidangUsaha($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function SeekHubunganDgNasabah($value='')
        {
            $search     = $this->input->get('q');
            $vdb        = $this->bdb->SeekHubunganDgNasabah($search) ;
            $dbd        = $vdb['db'] ;
            $vare       = array();
            while($dbr = $this->bdb->getrow($dbd)){
                $vare[]     = array("id"=>$dbr['Kode'], "text"=>$dbr['Kode'] ." - ".$dbr['Keterangan']) ;
            }
            $Result = json_encode($vare);
            echo($Result) ;
        }

        public function saving_image(){
            $fcfg   = array("upload_path"=>"./tmp/", "allowed_types"=>"jpg|jpeg|png", "overwrite"=>true) ;

            savesession($this, "ssmstregisterkaryawan_image", "") ;
            $this->load->library('upload', $fcfg) ;
            if ( ! $this->upload->do_upload(0) ){
                echo('
                    alert("'. $this->upload->display_errors('','') .'") ;
                    bos.mstregisterkaryawan.obj.find("#idlimage").html("") ;
                ') ;
            }else{
                $data   = $this->upload->data() ;
                $tname  = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vimage = array( $tname => $data['full_path']) ;
                savesession($this, "ssmstregisterkaryawan_image", json_encode($vimage) ) ;

                echo('
                    bos.mstregisterkaryawan.obj.find("#idlimage").html("") ;
                    bos.mstregisterkaryawan.obj.find("#idimage").html("<img src=\"'.base_url("./tmp/" . $data['client_name'] . "?time=". time()).'\" class=\"img-responsive\" />") ;
                ') ;
            }
        }

        public function saving_image_mapsusaha()
        {
            $fcfg   = array("upload_path"=>"./tmp/", "allowed_types"=>"jpg|jpeg|png", "overwrite"=>true) ;

            savesession($this, "ssmstregisterkaryawan_imageMapsUsaha", "") ;
            $this->load->library('upload', $fcfg) ;
            if ( ! $this->upload->do_upload(0) ){
                echo('
                    alert("'. $this->upload->display_errors('','') .'") ;
                    bos.mstregisterkaryawan.obj.find("#idlimageMapsUsaha").html("") ;
                ') ;
            }else{
                $data   = $this->upload->data() ;
                $tname  = str_replace($data['file_ext'], "", $data['client_name']) ;
                $vimage = array( $tname => $data['full_path']) ;
                savesession($this, "ssmstregisterkaryawan_imageMapsUsaha", json_encode($vimage) ) ;

                echo('
                    bos.mstregisterkaryawan.obj.find("#idlimageMapsUsaha").html("") ;
                    bos.mstregisterkaryawan.obj.find("#idimage_maps_usaha").html("<img src=\"'.base_url("./tmp/" . $data['client_name'] . "?time=". time()).'\" class=\"img-responsive\" />") ;
                ') ;
            }
        }

    }
    

?>