<?php 


/**
 * 
 */
class Rpt_logactivity_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        // echo print_r($va) ; exit() ;
        $limit      = $va['offset'].",".$va['limit'] ;
        
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $where 	    = array() ; 

        $dTglAwal       = date_2s($va['dTglAwal']);
        $dTglAkhir      = date_2s($va['dTglAkhir']);
        $cJenisFilter   = $va['cJenisFilter'];
        $optUserList    = (!isset($va['optUserList'])) ? "" : $va['optUserList'] ;
        
        $where[]    = "DATE(datetime) >= '{$dTglAwal}' AND DATE(datetime) <= '{$dTglAkhir}'" ;
        $cWhereUnit = "" ;
        if($cJenisFilter !== "A"){
            $cWhereUnit = " AND username = '{$optUserList}'" ;
        }

        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("sys_log_activity", "*", $where . $cWhereUnit, "", "", "DateTime DESC", $limit) ;
        $dba        = $this->select("sys_log_activity", "ID", $where . $cWhereUnit) ;

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

    public function seekUserList($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "username <> ''" ;
        if($search !== "") $cWhere[]   = "(username LIKE '%{$search}%' OR fullname LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("sys_username", "username , fullname", $cWhere, "", "", "username ASC") ;
        return array("db"=>$dbd) ;
    }

}

?>