<?php 


/**
 * 
 */
class Tcpsbi_mutanggaran_m extends Bismillah_Model
{
    
    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        
        $where 	    = array() ; 
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $where 	        = array() ; 
        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where[]    = "Status = '1'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("psbi_mutasi_anggaran", "*", $where, "", "", "Tgl DESC,Faktur DESC", $limit) ;
        $dba        = $this->select("psbi_mutasi_anggaran", "ID", $where) ;

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

    public function getFaktur($cKey,$dTgl,$l=true){
        $retVal = $this->getLastFaktur($cKey,$dTgl,true,15);  
        return $retVal; 
    }

    public function saving($va)
    {   
        if($va['cFaktur'] == "") $va['cFaktur'] = $this->getFaktur("A",$va['dTgl']);
        $this->updtransaksi_m->updAnggaranPSBI($va['cFaktur'],$va['dTgl'],$va['optGolonganPSBI'],$va['cKeterangan'],$va['nPlafond']) ;
        return "OK" ;
    }

    public function deleting($cKode)
    {
        $this->updtransaksi_m->deleteAnggaranPSBI($cKode);
    }

    

}