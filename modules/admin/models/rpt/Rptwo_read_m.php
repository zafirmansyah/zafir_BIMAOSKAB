<?php

class Rptwo_read_m extends Bismillah_Model
{

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_masuk")){
        $data = $d;
        }
        return $data ;
    }
    
}
?>