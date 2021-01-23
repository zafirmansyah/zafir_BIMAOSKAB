<?php 


/**
 * 
 */
class Rptpsbi_realisasi_m extends Bismillah_Model
{

    public function loadgrid($va){
        $limit           = $va['offset'].",".$va['limit'] ;
        $where 	         = array() ; 
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $where 	        = array() ; 
        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("psbi_realisasi", "*", $where, "", "", "TanggalRealisasi DESC", $limit) ;
        $dba        = $this->select("psbi_realisasi", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

}



?>