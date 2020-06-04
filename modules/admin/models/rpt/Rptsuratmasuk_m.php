<?php 


/**
 * 
 */
class Rptsuratmasuk_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $dbd      = $this->select("surat_masuk", "*", $where, "", "", "kode ASC", $limit) ;
        $dba      = $this->select("surat_masuk", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getDetailSuratMasuk($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk", $field, $where) ;
        return $dbd ;
    }

}

?>