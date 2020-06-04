<?php
class Username_m extends Bismillah_Model{
public function loadgrid($va){
    $limit	= $va['offset'].",".$va['limit'] ; //limit
    $dbd     = $this->select("sys_username", "username, fullname, cabang", "", "", "", "username DESC", $limit) ;
    $dba     = $this->select("sys_username", "username") ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
}
    
public function seekcabang($search){
    $where = "Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%'" ;
    $dbd      = $this->select("cabang", "*", $where, "", "", "keterangan ASC", '50') ;
    return array("db"=>$dbd) ;
}

public function PickNomorKaryawan($search){
    $where   = "Kode LIKE '%{$search}%' OR Nama LIKE '%{$search}%'" ;
    $dbd     = $this->select("karyawan", "*", $where, "", "", "Kode ASC", '50') ;
    return array("db"=>$dbd) ;
}

public function SeekUnit($search)
{   
    $cWhere     = array() ; 
    $cWhere[]   = "Kode <> ''" ;
    if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
    $cWhere     = implode(" AND ", $cWhere) ;
    $dbd        = $this->select("golongan_unit", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
    return array("db"=>$dbd) ;
}

public function GetKodeKaryawan()
{
    $nYear      = date('Y') ;
    $cKey  		= "OFFICER" . $nYear;
    $n    		= $this->getincrement($cKey,true,4);
    $cCIF    	= $n ;
    return $cCIF ;
}
}
?>
