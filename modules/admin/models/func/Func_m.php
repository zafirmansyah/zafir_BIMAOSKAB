<?php
class Func_m extends Bismillah_Model{

    public function GetKeterangan($cKode,$cFieldKeterangan,$cTable){
        if(empty($cFieldKeterangan)){
            $cFieldKeterangan = "keterangan" ;
        }
        $dbData = $this->select($cTable,$cFieldKeterangan,"Kode = '$cKode'");
        return $this->getrow($dbData) ;
    }

    public function devide($a,$b){
        $return = 0;
        if($a > 0 and $b > 0){
            $return = $a / $b;
        }
        return $return ;
    }

    public function GetHariCuti($dTglAwal='1988-01-01',$dTglAkhir='1988-01-01')
    {
        $dTglAwal   = date_2s($dTglAwal);
        $dTglAkhir  = date_2s($dTglAkhir);
        return $dTglAwal ;
    }
}
?>