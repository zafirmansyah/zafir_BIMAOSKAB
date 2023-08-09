<?php 


/**
 * 
 */
class Rptpsbi_komunikasi_m extends Bismillah_Model
{

    public function loadgrid($va){
        $limit           = $va['offset'].",".$va['limit'] ;
        $where 	         = array() ; 
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $dTglAwal             = date_2s($va['dTglAwal']);
        $dTglAkhir            = date_2s($va['dTglAkhir']);
        
        $where[]                 = "WaktuPelaksanaan >= '{$dTglAwal}' AND WaktuPelaksanaan <= '{$dTglAkhir}'" ;
        
        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("psbi_komunikasi", "*", $where, "", "", "WaktuPelaksanaan DESC", $limit) ;
        $dba        = $this->select("psbi_komunikasi", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function SeekGolonganPSBI($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("psbi_golongan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function SeekLokasiPSBI($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("psbi_lokasi", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

}



?>