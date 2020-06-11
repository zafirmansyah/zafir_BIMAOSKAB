<?php 


/**
 * 
 */
class Rptsuratmasuk_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $cUserName = getsession($this,"KodeKaryawan");
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        if(getsession($this,"Jabatan") > "002") $where[] = "d.Terdisposisi = '$cUserName'";
        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $join    = "left join surat_masuk_disposisi d on d.Kode=s.Kode";
        $dbd      = $this->select("surat_masuk s", "s.*,d.*", $where, $join, "", "s.Kode DESC", $limit) ;
        $dba      = $this->select("surat_masuk s", "s.ID", $where, $join) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
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

}

?>