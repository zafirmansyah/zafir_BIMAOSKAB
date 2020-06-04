<?php 


/**
 * 
 */
class Mstgol_unit_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $where 	 = array() ; 
    if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR keterangan LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("golongan_unit", "*", $where, "", "", "kode ASC", $limit) ;
    $dba      = $this->select("golongan_unit", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function saving($id, $va){
    $vaData   = array("Kode"=>$id, 
                      "Keterangan"=>$va['cKeterangan']) ;
    $where    = "Kode = " . $this->escape($id) ;
    $this->update("golongan_unit", $vaData, $where, "") ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "Kode = " . $this->escape($id), "golongan_unit")){
      $data = $d;
    }
    return $data ;
  }

  public function deleting($id){
    $this->delete("golongan_unit", "Kode = " . $this->escape($id)) ;
  }

  public function getIncreamentKode()
  {
    $cKey  		= "mstgolongan_unit_" ;
    $n    		= $this->getincrement($cKey,true,3);
    $cKode    = $n ;
    return $cKode ;
  }

}

 ?>