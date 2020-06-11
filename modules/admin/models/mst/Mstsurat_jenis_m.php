<?php 


/**
 * 
 */
class Mstsurat_jenis_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $where 	 = array() ; 
    if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR keterangan LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("jenis_surat", "*", $where, "", "", "kode ASC", $limit) ;
    $dba      = $this->select("jenis_surat", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function saving($id, $va){
    $vaData   = array("Kode"=>$id, 
                      "Keterangan"=>$va['cKeterangan'],
                      "KodeRubrik"=>$va['cRubrik']) ;
    $where    = "Kode = " . $this->escape($id) ;
    $this->update("jenis_surat", $vaData, $where, "") ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "Kode = " . $this->escape($id), "jenis_surat")){
      $data = $d;
    }
    return $data ;
  }

  public function deleting($id){
    $this->delete("jenis_surat", "Kode = " . $this->escape($id)) ;
  }

  public function getIncreamentKode()
  {
    $cKey  		= "mstjenis_surat_" ;
    $n    		= $this->getincrement($cKey,true,3);
    $cKode    = $n ;
    return $cKode ;
  }

}

 ?>