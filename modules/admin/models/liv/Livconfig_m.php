<?php
class Livconfig_m extends Bismillah_Model{
    public function loadgrid($va){
        $limit	    = $va['offset'].",".$va['limit'] ; //limit
        $dbd        = $this->select("cfg_leave", "ID,Keterangan,TglAwal,TglAkhir,HakKepada", "", "", "", "TglAwal DESC", $limit) ;
        $dba        = $this->select("cfg_leave", "ID") ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function PickNomorKaryawan($search){
        $where   = "Kode LIKE '%{$search}%' OR Nama LIKE '%{$search}%'" ;
        $dbd     = $this->select("karyawan", "*", $where, "", "", "Kode ASC", '50') ;
        return array("db"=>$dbd) ;
    }

    public function savingProcess($va)
    {
        $vaData = array(
            "Keterangan"=> $va['cKeterangan'],
            "TglAwal"   => date_2s($va['dTglAwal']),
            "TglAkhir"  => date_2s($va['dTglAkhir']),
            "JumlahHari"=> $va['cJumlahHari'],
            "HakKepada" => $va['HakKepada'],
            "UserName"  => getsession($this, "username")
        );
        $this->insert("cfg_leave",$vaData);
    }
}
?>
