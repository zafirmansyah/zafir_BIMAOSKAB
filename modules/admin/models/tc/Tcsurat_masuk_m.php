<?php 


/**
 * 
 */
class Tcsurat_masuk_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $dbd      = $this->select("surat_masuk", "*", $where, "", "", "Kode DESC", $limit) ;
        $dba      = $this->select("surat_masuk", "ID", $where) ;

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
    
    public function getKodeSurat()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "SM" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getNomorSurat()
    {
        $nReturn = 1 ;
        $cTable  = "surat_masuk" ;
        $cField  = "NoSurat" ;
        $cWhere  = "JenisSurat = '$cJenisSurat'" ;
        $cOrder  = "Tgl DESC" ;
        $nLimit  = "0,1" ;
        $dbData  = $this->select($cTable,$cField,$cWhere,"","",$cOrder,$nLimit) ;
        if($dbRow = $this->getrow($dbData)){
            $nReturn = $dbRow['NoSurat'] + 1 ;
        }
        return $nReturn ;
    }

    public function saving($va){

        $cKode = $va['cKode'] ;

        $cUserName                 = getsession($this,'username') ;
        $cKodeKaryawanPendisposisi = $this->getval("KodeKaryawan", "username = '$cUserName'","sys_username") ;

        $vaData         = array("Kode"=>$cKode, 
                                "NoSurat"=>"",
                                "Dari"=>$va['cSuratDari'],
                                "Tgl"=>date_2s($va['dTgl']),
                                "TglSurat"=>date_2s($va['dTglSurat']),
                                "Perihal"=>$va['cPerihal'],
                                "NoSurat"=>$va['cNomorSurat'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s'),
                                "Path"=>$va['FilePath']
                                ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->update("surat_masuk", $vaData, $where, "") ;
        
        //insert detail po
        $vaGrid = json_decode($va['dataDisposisi']);
        $this->delete("surat_masuk_disposisi", "Kode = '{$cKode}'" ) ;
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

        return $vaData ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['cKode'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData = array("Kode"=>$cKode, 
                        "Tgl"=>date_2s($va['dTgl']),
                        "FilePath"=>$va['FilePath'],
                        "UserName"=>$cUserName ,
                        "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("surat_masuk_file", $vaData, $where, "") ;
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cKode'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('surat_masuk_file',$cWhere);
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_masuk")){
        $data = $d;
        }
        return $data ;
    }

    public function getDataDisposisi($id){
        $field = "*";
        $where = "Kode = '$id'";
        $dbd   = $this->select("surat_masuk_disposisi", $field, $where) ;
        return $dbd ;
    }

    public function deleting($id){
        $this->delete("surat_masuk", "Kode = " . $this->escape($id)) ;
    }

    public function getIncreamentKode()
    {
        $cKey  		= "mstsurat_masuk_" ;
        $n    		= $this->getincrement($cKey,true,3);
        $cKode    = $n ;
        return $cKode ;
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