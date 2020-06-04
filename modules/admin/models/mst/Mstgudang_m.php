<?php
class Mstgudang_m extends Bismillah_Model{
   public function loadgrid($va){
      $limit    = $va['offset'].",".$va['limit'] ;
      $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
      $search   = $this->escape_like_str($search) ;
      $where 	 = array() ; 
      if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR keterangan LIKE '%{$search}%')" ;
      $where 	 = implode(" AND ", $where) ;
      $dbd      = $this->select("gudang", "*", $where, "", "", "kode ASC", $limit) ;
      $dba      = $this->select("gudang", "id", $where) ;

      return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
   }

   public function saving($kode, $va){
      $data    = array("kode"=>$va['kode'], "keterangan"=>$va['keterangan'], "username"=> getsession($this, "username")) ;
      $where   = "kode = " . $this->escape($kode) ;
      $this->update("gudang", $data, $where, "") ;
   }

   public function getdata($kode){
      $data = array() ;
		if($d = $this->getval("*", "kode = " . $this->escape($kode), "gudang")){
         $data = $d;
		}
		return $data ;
   }

   public function deleting($kode){
      $this->delete("gudang", "kode = " . $this->escape($kode)) ;
   }
}
?>
