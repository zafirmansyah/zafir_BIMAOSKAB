<?php 


/**
 * 
 */
class Rptsurat_keluar_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        
        $where 	    = array() ; 

        $dTglAwal   = date_2s($va['dTglAwal']);
        $dTglAkhir  = date_2s($va['dTglAkhir']);
        $cMetodeUK  = $va['cMetodeUK'];
        $optUnit    = $va['optUnit'];
        
        $where[]    = "Tgl >= '{$dTglAwal}' AND Tgl <= '{$dTglAkhir}'" ;
        $cWhereUnit = "" ;
        if($cMetodeUK !== "A"){
            $cWhereUnit = " AND Unit = '{$optUnit}'" ;
        }

        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("surat_keluar", "*", $where . $cWhereUnit, "", "", "DateTime DESC, Kode DESC", $limit) ;
        $dba        = $this->select("surat_keluar", "ID", $where . $cWhereUnit) ;

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

    public function seekUnit($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("golongan_unit", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

}

?>