<?php

class Rptm02_prinsip_read_m extends Bismillah_Model
{
    
    public function createFakturMutasiStatusM02Prinsip()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "FM02P" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_masuk")){
        $data = $d;
        }
        return $data ;
    }
    
    public function loadGridDataUserDisposisi($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(KodeKaryawan LIKE '{$search}%' OR fullname LIKE '%{$search}%')" ;
        $where[]    = "Jabatan > '002' AND Jabatan <> ''";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("sys_username", "*", $where, "", "", "KodeKaryawan ASC", $limit) ;
        $dba        = $this->select("sys_username", "KodeKaryawan", $where) ;
        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getDataTargetDisposisi($cKode){
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }
    
    public function SeekJenisSurat($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("jenis_surat", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function saving($va){

        $cKode = $va['cKode'] ;

        $cUserName                 = getsession($this,'username') ;
        $cKodeKaryawanPendisposisi = $this->getval("KodeKaryawan", "username = '$cUserName'","sys_username") ;

        //insert detail po
        $vaGrid = json_decode($va['dataDisposisi']);
        //$this->delete("surat_masuk_disposisi", "Kode = '{$cKode}'" ) ;
        foreach($vaGrid as $key => $val){
            $where      = "Kode = " . $this->escape($cKode) ;
            $vadetail = array("Kode"=>$cKode,
                              "Tgl"=>date_2s($va['dTgl']),
                              "Pendisposisi"=>$cKodeKaryawanPendisposisi,
                              "Terdisposisi"=>$val->kode,
                              "Level"=>$val->level,
                              "Status"=>"1",
                              "UserName"=>$cUserName,
                              "DateTime"=>date('Y-m-d H:i:s')
                            );
            $this->insert("surat_masuk_disposisi",$vadetail);
        }        

        // Trigger Notifikasi Ke Masing2 Terdisposisi

        require APPPATH . '../vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '1d87ad16eb0bd12a181f',
            '059b5835bf2f02c082d3',
            '1010070',
            $options
        );

        $data['message'] = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);

        return $vaGrid ;
    }

    public function actReject($va)
    {
        $cUserName          = getsession($this,'username') ;
        $cFakturMutasi      = $this->createFakturMutasiStatusM02Prinsip() ;
        $dTgl               = date("Y-m-d");
        $cPenolakan         = $va['cPenolakan'];
        $cFakturDokumen     = $va['cFakturDokumen'];
        $cKodeDispo         = $va['cKodeDispo'];
        $cKodeKaryawan      = $va['cKodeKaryawan'];
        
        $vaInsert = array("Faktur"=>$cFakturMutasi,
                          "FakturDisposisi"=>$cKodeDispo,
                          "Tgl"=>$dTgl,
                          "Status"=>"3",
                          "Keterangan"=>$cPenolakan,
                          "UserName"=>$cUserName,
                          "DateTime"=>date('Y-m-d H:i:s'),
                          "Terdisposisi"=>$cKodeKaryawan) ;
        $this->Insert("m02_prinsip_status",$vaInsert) ;

        $cWhere   = "FakturDokumen = '{$cFakturDokumen}' AND Kode = '{$cKodeDispo}' AND Terdisposisi = '{$cKodeKaryawan}'";
        $vaUpdate = array("Status"=>'0');
        $this->Update("m02_prinsip_disposisi",$vaUpdate,$cWhere) ;
    }

    public function actAccept($va)
    {
        $cUserName          = getsession($this,'username') ;
        $cFakturMutasi      = $this->createFakturMutasiStatusM02Prinsip() ;
        $dTgl               = date("Y-m-d");
        $cFakturDokumen     = $va['cFakturDokumen'];
        $cKodeDispo         = $va['cKodeDispo'];
        $cKodeKaryawan      = $va['cKodeKaryawan'];
        
        $vaInsert = array("Faktur"=>$cFakturMutasi,
                          "FakturDisposisi"=>$cKodeDispo,
                          "Tgl"=>$dTgl,
                          "Status"=>"1",
                          "Keterangan"=>"ACC",
                          "UserName"=>$cUserName,
                          "DateTime"=>date('Y-m-d H:i:s'),
                          "Terdisposisi"=>$cKodeKaryawan) ;
        $this->Insert("m02_prinsip_status",$vaInsert) ;

        $cWhereCheck        = "FakturDokumen = '{$cFakturDokumen}' AND Kode = '{$cKodeDispo}' AND Status = '0' AND Terdisposisi <> '{$cKodeKaryawan}'" ;
        $dbCheckTerdispo    = $this->select("m02_prinsip_disposisi","FakturDokumen,Kode,Terdisposisi,Level",$cWhereCheck,'','','Level ASC','0,1') ;
        if($dbRowCheckDispo = $this->getrow($dbCheckTerdispo)){
            $cKodeKaryawanNext = $dbRowCheckDispo['Terdisposisi'] ;
            $cWhere     = "FakturDokumen = '{$cFakturDokumen}' AND Kode = '{$cKodeDispo}' AND Status = '0' AND Terdisposisi = '{$cKodeKaryawanNext}'" ;
            $vaUpdate   = array("Status"=>'1');
            $this->Update("m02_prinsip_disposisi",$vaUpdate,$cWhere) ;    
        }

        
    } 

    public function deleteFile($va)
    {
        $cKode  = $va['cFakturDokumen'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('m02_prinsip_file',$cWhere);
    }

    public function saveFile($va)
    {
        $cKode          = $va['cFakturDokumen'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date('Y-m-d'),
                                "FilePath"=>$va['FilePath'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s')) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("m02_prinsip_file", $vaData, $where, "") ;
    }
}


?>