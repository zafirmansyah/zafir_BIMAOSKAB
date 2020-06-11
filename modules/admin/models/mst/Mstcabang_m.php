<?php
class Mstcabang_m extends Bismillah_Model{

   public function getIncreamentKode()
   {
      $cKey  		= "mstBranchOffice_" ;
      $n    		= $this->getincrement($cKey,true,3);
      $cKode      = $n ;
      return $cKode ;
   }

   public function loadgrid($va){
      $limit    = $va['offset'].",".$va['limit'] ;
      $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
      $search   = $this->escape_like_str($search) ;
      $where 	 = array() ; 
      if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Keterangan LIKE '%{$search}%')" ;
      $where 	 = implode(" AND ", $where) ;
      $dbd      = $this->select("cabang", "*", $where, "", "", "kode ASC", $limit) ;
      $dba      = $this->select("cabang", "id", $where) ;

      return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
   }

   public function saving($id, $va){
      $vaData  = array("Kode" => $id,
                        "Keterangan" => $va['cKeterangan'],
                        "Alamat" => $va['cAlamat'],
                        "Kota" => $va['optKota'],
                        "Kecamatan" => $va['optKecamatan'],
                        "Kelurahan" => $va['optKelurahan'],
                        "KodePos" => $va['cKodePos'],
                        "NoTelepon" => $va['cNoTelepon'],
                        "NoFax" => $va['cNoFax']); 
      $where   = "Kode = " . $this->escape($id) ;
      $this->update("cabang", $vaData, $where, "") ;
   }

   public function getdata($id){
      $data = array() ;
		if($d = $this->getval("*", "Kode = " . $this->escape($id), "cabang")){
         $data = $d;
		}
		return $data ;
   }

   public function deleting($id){
      $this->delete("cabang", "Kode = " . $this->escape($id)) ;
   }

   public function SeekKota($search)
   {   
      $cWhere     = array() ; 
      $cWhere[]   = "Kode <> ''" ;
      if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
      $cWhere     = implode(" AND ", $cWhere) ;
      $dbd        = $this->select("kota", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
      return array("db"=>$dbd) ;
   }

   public function SeekKecamatan($search='',$cKota='')
   {   
      $cWhere     = array() ; 
      $cWhere[]   = "Kode LIKE '$cKota.%'" ;
      if($search !== "") $cWhere[]   = "(Keterangan LIKE '%{$search}%')" ;
      $cWhere     = implode(" AND ", $cWhere) ;
      $dbd        = $this->select("kecamatan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
      return array("db"=>$dbd) ;
   }

   public function SeekKelurahan($search='',$cKecamatan='')
   {   
      $cWhere     = array() ; 
      $cWhere[]   = "Kode LIKE '$cKecamatan.%'" ;
      if($search !== "") $cWhere[]   = "(Keterangan LIKE '%{$search}%')" ;
      $cWhere     = implode(" AND ", $cWhere) ;
      $dbd        = $this->select("kelurahan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
      return array("db"=>$dbd) ;
   }
}
?>
