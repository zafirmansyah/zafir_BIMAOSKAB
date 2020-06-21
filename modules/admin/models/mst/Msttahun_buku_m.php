<?php 


/**
 * 
 */
class Msttahun_buku_m extends Bismillah_Model
{
	
  public function loadgrid($va){
    $limit    = $va['offset'].",".$va['limit'] ;
    $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
    $search   = $this->escape_like_str($search) ;
    $where 	 = array() ; 
    if($search !== "") $where[]	= "(TahunBuku LIKE '{$search}%' OR KodeTahunBuku LIKE '%{$search}%')" ;
    $where 	 = implode(" AND ", $where) ;
    $dbd      = $this->select("tahun_buku", "*", $where, "", "", "TahunBuku ASC", $limit) ;
    $dba      = $this->select("tahun_buku", "id", $where) ;

    return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
  }

  public function saving($id, $va){
    $vaData   = array("TahunBuku"=>$id, 
                      "KodeTahunBuku"=>$va['cKodeTahunBuku']) ;
    $where    = "TahunBuku = " . $this->escape($id) ;
    $this->update("tahun_buku", $vaData, $where, "") ;
  }

  public function getdata($id){
    $data = array() ;
    if($d = $this->getval("*", "TahunBuku = " . $this->escape($id), "tahun_buku")){
      $data = $d;
    }
    return $data ;
  }

  public function deleting($id){
    $this->delete("tahun_buku", "TahunBuku = " . $this->escape($id)) ;
  }

  public function getIncreamentTahunBuku()
  {
    $cKey  		= "msttahun_buku_" ;
    $n    		= $this->getincrement($cKey,true,3);
    $cTahunBuku    = $n ;
    return $cTahunBuku ;
  }

}

 ?>