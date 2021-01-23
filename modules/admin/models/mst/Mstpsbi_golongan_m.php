<?php 

/**
 * 
 */
class Mstpsbi_golongan_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $where 	 = array() ; 
    if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR keterangan LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("psbi_golongan", "*", $where, "", "", "kode ASC", $limit) ;
    $dba      = $this->select("psbi_golongan", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function saving($id, $va){
    $vaData   = array("Kode"=>$id, 
                      "Keterangan"=>$va['cKeterangan']) ;
    $where    = "Kode = " . $this->escape($id) ;
    $this->update("psbi_golongan", $vaData, $where, "") ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "Kode = " . $this->escape($id), "psbi_golongan")){
      $data = $d;
    }
    return $data ;
  }

  public function deleting($id){
    $this->delete("psbi_golongan", "Kode = " . $this->escape($id)) ;
  }

  public function getIncreamentKode()
  {
    $cKey  		= "mstpsbi_golongan_" ;
    $n    		= $this->getincrement($cKey,true,3);
    $cKode    = $n ;
    return $cKode ;
  }

}

 ?>