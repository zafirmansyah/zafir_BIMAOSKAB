<?php

class Tcm_anggaran_m extends Bismillah_Model
{
    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(Faktur LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("m02_anggaran", "*", $where, "", "", "Tgl DESC,Faktur ASC", $limit) ;
        $dba        = $this->select("m02_anggaran", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
}


?>