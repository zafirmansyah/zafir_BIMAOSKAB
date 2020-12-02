<?php 


/**
 * 
 */
class Rptsuratmasuk_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $cUserName  = getsession($this,"KodeKaryawan");
        $limit      = $va['offset'].",".$va['limit'] ;
        $cSrchField = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $cSrchValue = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        
        $cSrchField     = $this->escape_like_str($cSrchField) ;
        $cSrchValue     = $this->escape_like_str($cSrchValue) ;

        if($cSrchField == "s.Tgl" || $cSrchField == "d.Tgl") $cSrchValue = date_2s($cSrchValue);
        
        $where 	    = array() ; 
        $where[] = "(d.Terdisposisi = '$cUserName' OR d.Pendisposisi = '$cUserName')";
        if($cSrchValue !== "") $where[]	= "{$cSrchField} LIKE '%{$cSrchValue}%'" ;
        $where 	    = implode(" AND ", $where) ;
        $join       = "left join surat_masuk_disposisi d on d.Kode=s.Kode";
        $dbd        = $this->select("surat_masuk s", "s.*,d.Tgl as TglDisposisi, d.Terdisposisi", $where, $join, "s.Kode", "s.Kode DESC", $limit) ;
        $dba        = $this->select("surat_masuk s", "s.ID", $where, $join) ;
        
        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function loadLastTerdispo($cKode)
    {
        $cWhere = "Kode = '$cKode'" ;
        $dbd    = $this->select("surat_masuk_disposisi", "Terdisposisi", $cWhere,"","","ID DESC") ;
        return array("db"=>$dbd) ;
    }

    public function getDetailSuratMasuk($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk", $field, $where) ;
        return $dbd ;
    }
    public function getFileListSuratMasuk($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk_file", $field, $where) ;
        return $dbd;
    }

    public function getDisposisiListSuratMasuk($cKode){
        $field  = "*";
        $where  = "o.Kode = '$cKode'";
        $vaJoin = "LEFT JOIN sys_username s on s.KodeKaryawan = o.Terdisposisi";
        $dbd    = $this->select("surat_masuk_disposisi o", $field, $where, $vaJoin) ;
        return $dbd;
    }
    
    public function getHistorySuratMasuk($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk_disposisi o", $field, $where) ;
        return $dbd;
    }

    public function getUserNameByKodeKaryawan($cKodeKaryawan)
    {
        $cUserName = "";
        $field = "fullname AS username";
        $where = "KodeKaryawan = '$cKodeKaryawan'";
        $dbd   = $this->select("sys_username", $field, $where) ;
        if($dbr = $this->getrow($dbd)){
            $cUserName = $dbr['username'];
        }
        return $cUserName;
    }

    public function getDeskripsiDisposisiSurat($cKode,$cTerdisposisi)
    {
        $field = "Deskripsi";
        $where = "Kode = '$cKode' AND Terdisposisi = '$cTerdisposisi'";
        $dbd   = $this->select("surat_masuk_disposisi", $field, $where) ;
        $cDeskripsi = "";
        if($dbr = $this->getrow($dbd)){
            $cDeskripsi = $dbr['Deskripsi'];
        }
        return $cDeskripsi;
    }

    public function getLevelDisposisiSurat($cKode,$cTerdisposisi)
    {
        $field = "LevelDisposisi";
        $where = "Kode = '$cKode' AND Terdisposisi = '$cTerdisposisi'";
        $dbd   = $this->select("surat_masuk_disposisi", $field, $where) ;
        $cLevelDisposisi = "";
        if($dbr = $this->getrow($dbd)){
            $cLevelDisposisi = $dbr['LevelDisposisi'];
        }
        return $cLevelDisposisi;
    }

    public function getDataDetailSuratMasuk($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk", $field, $where) ;
        return $dbd;
    }

}

?>