<?php
class Config_m extends Bismillah_Model{
    public function savetransaksi($va){
        $this->saveconfig("cfgkodecabang",$va['kodecabang']);
        $this->saveconfig("cfgnamacabang",$va['namacabang']);
        $this->saveconfig("cfgalamatcabang",$va['alamatcabang']);
        $this->saveconfig("cfgtelpcabang",$va['telpcabang']);
        $this->saveconfig("cfgkasirprinturl",$va['kasirprinturl']);
        $this->saveconfig("cfgkasirprintcpl",$va['kasirprintcpl']);
        $this->saveconfig("cfgkasirprinter",$va['kasirprinter']);
        $this->saveconfig("cfgkasirbatasatas",$va['kasirbatasatas']);
        $this->saveconfig("cfgkasirbatasbawah",$va['kasirbatasbawah']);
        
        $this->saveconfig("cfgkasirprinth1",$va['kasirprinth1']);
        $this->saveconfig("cfgkasirprinth2",$va['kasirprinth2']);
        $this->saveconfig("cfgkasirprinth3",$va['kasirprinth3']);
        $this->saveconfig("cfgkasirprinth4",$va['kasirprinth4']);
        $this->saveconfig("cfgkasirprinth5",$va['kasirprinth5']);
        $this->saveconfig("cfgkasirprinth6",$va['kasirprinth6']);
        
        $this->saveconfig("cfgkasirprintf1",$va['kasirprintf1']);
        $this->saveconfig("cfgkasirprintf2",$va['kasirprintf2']);
        $this->saveconfig("cfgkasirprintf3",$va['kasirprintf3']);
        $this->saveconfig("cfgkasirprintf4",$va['kasirprintf4']);
        $this->saveconfig("cfgkasirprintf5",$va['kasirprintf5']);
        $this->saveconfig("cfgkasirprintf6",$va['kasirprintf6']);

        $this->saveconfig("cfgjasaparkir",$va['jasaparkir']);
    }

    public function seekjasaparkir($search){
      $where = "kode LIKE '%{$search}%' OR keterangan LIKE '%{$search}%'" ;
      $dbd      = $this->select("stock_group", "*", $where, "", "", "keterangan ASC", '50') ;
      return array("db"=>$dbd) ;
   }
}
?>
