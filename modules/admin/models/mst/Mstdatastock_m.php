<?php
class Mstdatastock_m extends Bismillah_Model{
   public function loadgrid($va){
      $limit    = $va['offset'].",".$va['limit'] ;
      $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
      $search   = $this->escape_like_str($search) ;
      $where 	 = array() ;
      if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR keterangan LIKE '%{$search}%')" ;
      $where 	 = implode(" AND ", $where) ;
      $join     = "left join stock_group g on g.Kode = s.stock_group";
      $field    = "s.*,g.Keterangan as KetStockGroup";
      $dbd      = $this->select("stock s", $field, $where, $join, "", "s.kode ASC", $limit) ;
      $dba      = $this->select("stock", "id", $where) ;

      return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
   }

    public function loadgrid2($kode){
      //$limit    = $va['offset'].",".$va['limit'] ;
      //$search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
      //$search   = $this->escape_like_str($search) ;
      $where 	 = "paket = 0 and kode <> '$kode'" ;
      $dbd      = $this->select("stock", "*", $where, "", "", "keterangan ASC") ;
      $dba      = $this->select("stock", "id", $where) ;

      return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
   }
   
    public function checkpaket($paket,$kode){
      //$limit    = $va['offset'].",".$va['limit'] ;
      //$search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
      //$search   = $this->escape_like_str($search) ;
      $va = array("status"=>0,"qty"=>0);
      $where 	 = "kode = '$kode' and paket = '$paket'" ;
      $dbd      = $this->select("stock_paket", "*", $where, "", "", "kode ASC","1") ;
      if($dbr = $this->getrow($dbd)){
        $va['status'] = 1;
        $va['qty'] = $dbr['qty'];
      }

      return $va;
   }
   public function saving($kode, $va){
      $kode = getsession($this, "ssstock_kode", "");
      $va['kode'] = $kode !== "" ? $kode : $this->getkode() ;
      $vaGrid = json_decode($va['grid2']);

      //delete paket lalu insert ulang
      $this->delete("stock_paket", "paket = '{$va['kode']}'") ;
      $va['paket'] = 0;
      //print_r($vaGrid);
      foreach($vaGrid as $key => $val){
        if($val->ck){
            $va['paket'] = 1;
            $vapaket = array("Kode"=>$val->kode,"paket"=>$va['kode'],"qty"=>$val->qty,"username"=> getsession($this, "username"));
            $this->insert("stock_paket",$vapaket);
        }
      }

      // save data stock
      $data    = array("kode"=>$va['kode'],"satuan"=>$va['satuan'],"stock_group"=>$va['group'],"hargajual"=>$va['hargajual'], 
                       "paket"=>$va['paket'],"keterangan"=>$va['keterangan'], "username"=> getsession($this, "username")) ;
      $where   = "kode = " . $this->escape($kode) ;
      $this->update("stock", $data, $where, "") ;
       
      //save gambar biar gak error harus dipisahkan
      if($va['data_var'] == "null" || $va['data_var'] == null || $va['data_var'] == ""){
          $va['data_var'] = "";
      }else{
          $data    = array("file_photo"=>$va['data_var']);
          $where   = "kode = " . $this->escape($kode) ;
          $this->edit("stock", $data, $where, "") ;
      }
   }
   public function getdata($kode){
      $data = array() ;
      $where 	 = "s.kode = " . $this->escape($kode);
      $join     = "left join stock_group g on g.Kode = s.stock_group left join satuan t on t.kode = s.satuan";
      $field    = "s.*,g.Keterangan as KetStockGroup,t.Keterangan as KetSatuan";
      $dbd      = $this->select("stock s", $field, $where, $join, "", "s.kode ASC","1") ;
	  return $dbd;
   }

   public function deleting($kode){
      $this->delete("stock", "kode = " . $this->escape($kode)) ;
   }

   public function seeksatuan($search){
      $where = "kode LIKE '%{$search}%' OR keterangan LIKE '%{$search}%'" ;
      $dbd      = $this->select("satuan", "*", $where, "", "", "keterangan ASC", '50') ;
      return array("db"=>$dbd) ;
   }
   
   public function seekgroup($search){
      $where = "kode LIKE '%{$search}%' OR keterangan LIKE '%{$search}%'" ;
      $dbd      = $this->select("stock_group", "*", $where, "", "", "keterangan ASC", '50') ;
      return array("db"=>$dbd) ;
   }
    
   public function getkode($l=true){
      $y    = date("ym");
      $n    = $this->getincrement("stockkode" . $y, $l, 6);
      $n    = $y.$n ;
      return $n ;
   }
}
?>
