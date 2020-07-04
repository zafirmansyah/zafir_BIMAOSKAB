<?php

class Tcm_prinsip_m extends Bismillah_Model
{
    public function getKodeSurat()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "M02P" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getKodeDispoSurat()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "M02P_DISPO" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function SeekSifatSurat($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("jenis_sifat_surat", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(Faktur LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where[]    = "Status = '1'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("m02_prinsip", "*", $where, "", "", "Tgl DESC,Faktur DESC", $limit) ;
        $dba        = $this->select("m02_prinsip", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function loadGridDataUserDisposisi($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(KodeKaryawan LIKE '{$search}%' OR fullname LIKE '%{$search}%')" ;
        $where[]    = "Jabatan <= '002'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("sys_username", "*", $where, "", "", "KodeKaryawan ASC", $limit) ;
        $dba        = $this->select("sys_username", "KodeKaryawan", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function saveData($va)
    {
        $cUserName  = getsession($this,'username') ;
        $vaData     = array("Faktur"=>$va['cFaktur'],
                            "Perihal"=>$va['cSubject'],
                            "Deskripsi"=>$va['cDeskripsi'],
                            "MetodeDisposisi"=>$va['optMetode'],
                            "Tgl"=>date_2s($va['dTgl']),
                            "NoSurat"=>$va['cNoSurat'],
                            "StatusPersetujuan"=>"0",
                            "Sifat"=>$va['optSifatSurat'],
                            "Status"=>"1",
                            "MetodeDisposisi"=>$va['optMetode'],
                            "UserName"=>$cUserName,
                            "DateTime"=>date("Y-m-d H:i:s"));
        $where      = "Faktur = " . $this->escape($va['cFaktur']) ;
        $this->update("m02_prinsip", $vaData, $where, "") ;
        return "OK" ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['cFaktur'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date_2s($va['dTgl']),
                                "FilePath"=>$va['FilePath'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s')) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("m02_prinsip_file", $vaData, $where, "") ;
    }

    public function saveDataDisposisi($va)
    {
        //insert detail dispo
        $cKode                     = $va['cFaktur'] ;
        $cKodeDispo                = $va['cKodeDispo'] ;
        $vaGrid                    = json_decode($va['dataDisposisi']);
        $cUserName                 = getsession($this,'username') ;
        $cKodeKaryawanPendisposisi = $this->getval("KodeKaryawan", "username = '$cUserName'","sys_username") ;
        $this->delete("m02_prinsip_disposisi", "Kode = '{$cKode}'" ) ;
        foreach($vaGrid as $key => $val){
            $nLevel = $val->level ;
            $cStatus = '0' ;
            if($nLevel == "1"){
                $cStatus = '1' ;
            }
            $where    = "Kode = " . $this->escape($cKode) ;
            $vadetail = array("Kode"=>$cKodeDispo,
                              "FakturDokumen"=>$cKode,
                              "Tgl"=>date_2s($va['dTgl']),
                              "Pendisposisi"=>$cKodeKaryawanPendisposisi,
                              "Terdisposisi"=>$val->kode,
                              "Level"=>$nLevel,
                              "Status"=>$cStatus,
                              "UserName"=>$cUserName,
                              "DateTime"=>date('Y-m-d H:i:s')
                            );
            $this->insert("m02_prinsip_disposisi",$vadetail);
            
            // Send Email Notification to All Reciever

            $cReceiverKode   = $val->kode ;
            $cReceiverEmail  = $this->getval("Email", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
            $cReceiverName   = $this->getval("fullname", "KodeKaryawan = '{$cReceiverKode}'", "sys_username") ; 
            $cSenderName     = $this->getval("fullname", "KodeKaryawan = '{$cKodeKaryawanPendisposisi}'", "sys_username") ; 

            $subjectMail    = "NOTIFIKASI BIMA OSKAB - Dokumen M.02 Persetujuan Prinsip Terdisposisi Pada Anda" ;
            $headers        = "MIME-Version: 1.0" . "\r\n";
            $headers        .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers        .= 'From: <bimaoskab@gmail.com>' . "\r\n";
            $message = "
                <html>
                    <body>
                    
                    <p>Hallo ".$cReceiverName.",</p>
                    <p>".$cSenderName." mendisposisi kepada Anda dokumen M.02 Persetujuan Prinsip, perihal ".$va['cSubject']."</p>
                    
                    <p>
                        <a href='bimaoskab.com'>
                            <b>Klik Link Ini Untuk Menuju Aplikasi BIMA OSKAB</b>
                        </a>
                    </p>

                    <p>Terima Kasih</p>
                    <p><b>BIMA OSKAB</b></p>

                    </body>
                </html>
            ";
            
            mail($cReceiverEmail,$subjectMail,$message,$headers);

        }     
        
        $vaUpd = array("KodeDisposisi"=>$cKodeDispo) ;
        $this->update("m02_prinsip",$vaUpd,"Faktur = '{$cKode}'","");   

        // Input Data ke M02_prinsip_status sebagai mutasi persetujuan
        
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cFaktur'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('m02_prinsip_file',$cWhere);
    }

    public function deletePrinsip($id)
    {
        $vaDel = array("status"=>'0');
        $this->update("m02_prinsip",$vaDel,"Faktur = '{$id}'","") ;
    }

    public function getDataDetail($cFaktur)
    {
        $data = array() ;
        if($d = $this->getval("*", "Faktur = " . $this->escape($cFaktur), "m02_prinsip")){
            $data = $d;
        }
        return $data ;
    }

    public function getDataTargetDisposisi($cKode)
    {
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }
}


?>