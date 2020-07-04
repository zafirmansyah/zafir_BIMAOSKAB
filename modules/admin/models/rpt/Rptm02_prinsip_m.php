<?php 


/**
 * 
 */
class Rptm02_prinsip_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $cKodeKaryawan  = getsession($this,"KodeKaryawan") ;
        $limit          = $va['offset'].",".$va['limit'] ;
        $search	        = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search         = $this->escape_like_str($search) ;
        $where 	        = array() ; 
        if($search !== "") $where[]	= "(s.NoSurat LIKE '%{$search}%' OR s.Perihal LIKE '%{$search}%')" ;
        $where[]        = "d.Pendisposisi = '{$cKodeKaryawan}'";
        $where 	        = implode(" AND ", $where) ;
        $orWhere        = " OR d.Terdisposisi = '{$cKodeKaryawan}'" ;
        $join           = "left join m02_prinsip_disposisi d on d.FakturDokumen = s.Faktur";
        $cField         = "s.Faktur AS FakturDokumen, s.Perihal, s.Deskripsi, s.NoSurat, s.Sifat, s.UserName as UserMaker, s.DateTime, s.Tgl,
                           s.KodeDisposisi, s.MetodeDisposisi, d.`Level`, d.Pendisposisi, d.Terdisposisi, d.`Status` AS StatusMunculDisposisi";
        $dbd            = $this->select("m02_prinsip s", $cField, $where . $orWhere, $join, "s.Faktur", "s.Faktur DESC", $limit) ;
        $dba            = $this->select("m02_prinsip s", $cField, $where, $join) ;
        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getDetailSuratMasuk($cKode)
    {
        $field = "*";
        $where = "Faktur = '$cKode'";
        $dbd   = $this->select("m02_prinsip", $field, $where) ;
        return $dbd ;
    }
    
    public function getFileListSuratMasuk($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("m02_prinsip_file", $field, $where) ;
        return $dbd;
    }

    public function getDetailTimeLineM02($cFaktur)
    {
        $field = "*";
        $where = "FakturDisposisi = '$cFaktur'";
        $dbd   = $this->select("m02_prinsip_status", $field, $where) ;
        return $dbd ;
    }

    public function getKodeDisposisi($cFaktur)
    {
        $cKodeDisposisi = "";
        $field = "KodeDisposisi";
        $where = "Faktur = '$cFaktur'";
        $dbd   = $this->select("m02_prinsip", $field, $where) ;
        if($dbr = $this->getrow($dbd)){
            $cKodeDisposisi = $dbr['KodeDisposisi'];
        }
        return $cKodeDisposisi;
    }

}

?>