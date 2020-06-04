<?php 


/**
 * 
 */
class Mstjabatan_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $where 	 = array() ; 
    if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR Nama LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("golongandivisi", "*", $where, "", "", "kode ASC", $limit) ;
    $dba      = $this->select("golongandivisi", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function loadgrid_jabatan($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $cKodeDivisi = $va['cKodeDivisi'];
    $where 	 = array() ; 
    $where[]   = "GolonganDivisi = '$cKodeDivisi'" ;
    if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Keterangan LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("jabatan", "*", $where, "", "", "GolonganDivisi ASC", $limit) ;
    $dba      = $this->select("jabatan", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function saving($id, $va){
    $vaData  = array("Kode"=>$id, 
                     "Keterangan"=>$va['cNamaJabatan'], 
                     "GolonganDivisi"=>$va['optDivisi']) ;
    $where   = "Kode = " . $this->escape($id) ;
    $this->update("jabatan", $vaData, $where, "") ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "Kode = " . $this->escape($id), "jabatan")){
      $data = $d;
    }
    return $data ;
  }

  public function deleting($kode){
    $this->delete("golongandivisi", "kode = " . $this->escape($kode)) ;
  }

  public function SeekDivisi($search)
  {
    $where      = "(Kode LIKE '%{$search}%' OR Nama LIKE '%{$search}%')" ;
    $dbd        = $this->select("golongandivisi", "Kode,Nama", $where, "", "", "Kode ASC") ;
    return array("db"=>$dbd) ;
  }

  public function getIncreamentKode()
  {
    $cKey  		= "mstJabatan_" ;
    $n    		= $this->getincrement($cKey,true,3);
    $cKode    = $n ;
    return $cKode ;
  }


}

 ?>