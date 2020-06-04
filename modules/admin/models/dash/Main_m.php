<?php
class Main_m extends Bismillah_Model{
    public function getcountstock(){
        $dbd      = $this->select("stock", "*", "","", "", "kode ASC") ;
        $return   = $this->rows($dbd);
        return $return;
    }
    
    public function getpenjualantot(){
        $tgl = date("Y-m-d");
        $return = array();
        $field = "sum(Total) as jmlpenj,count(faktur) jmlfkt";
        $where = "tgl  = '$tgl' and status <> '2'";
        $dbd      = $this->select("penjualankasir_total", $field, $where,"", "", "") ;
        if($dbr = $this->getrow($dbd)){
            $return = $dbr;
        } 
        return $return;
    }

    public function getpenjualanitem($item){

    }
}
?>