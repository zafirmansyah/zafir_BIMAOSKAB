<?php

class Frame_m extends Bismillah_Model{

    public function getDetailSuratMasuk($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk", $field, $where) ;
        return $dbd ;
    }
    
    public function getFileListSuratMasuk($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("surat_masuk_file", $field, $where) ;
        return $dbd;
    }

    // M02 Persetujuan Prinsip
    public function getDetailM02($cKode)
    {
        $field = "*";
        $where = "Faktur = '$cKode'";
        $dbd   = $this->select("m02_prinsip", $field, $where) ;
        return $dbd ;
    }
    
    public function getFileListM02($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("m02_prinsip_file", $field, $where) ;
        return $dbd;
    }


    // Work Order
    public function getDetailFormWO($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("work_order_form", $field, $where, "Faktur","EndDateTime ASC,Faktur ASC") ;
        return $dbd ;
    }
    public function getFileFormWO($cFaktur){
        $field = "*";
        $where = "Faktur = '$cFaktur'";
        $dbd   = $this->select("work_order_form_file", $field, $where) ;
        return $dbd;
    }
    public function getFileWO($cKode){
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("work_order_master_file", $field, $where) ;
        return $dbd;
    }
    public function getStatusCaseClosed($cKode)
    {
        $cStatus = "" ;
        $dbd = $this->select("work_order_master","CaseClosed", "Kode = " . $this->escape($cKode));
        if($dbr = $this->getrow($dbd)){
            $cStatus = $dbr['CaseClosed'];
        } 
		return $cStatus ;
    }
    public function getDataWO($id){
        $where[]   = "Kode = " . $this->escape($id);
        $where 	   = implode(" AND ", $where) ;
        if($d = $this->getval("*", $where, "work_order_master")){
            $data = $d;
        }
        return $data ;
    }
}

?>