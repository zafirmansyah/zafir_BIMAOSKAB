<?php 


/**
 * 
 */
class Tcpsbi_realisasi_m extends Bismillah_Model
{

    public function loadgrid($va){
        $limit           = $va['offset'].",".$va['limit'] ;
        $where 	         = array() ; 
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $where 	        = array() ; 
        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("psbi_realisasi", "*", $where, "", "", "TanggalRealisasi DESC", $limit) ;
        $dba        = $this->select("psbi_realisasi", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function SeekGolonganPSBI($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("psbi_golongan", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function SeekLokasiPSBI($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("psbi_lokasi", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function getFaktur($cKey,$dTgl,$l=true){
        $retVal = $this->getLastFaktur($cKey,$dTgl,true,15);  
        return $retVal; 
    }

    public function saveData($va)
    {   
        $this->updtransaksi_m->updRealisasiPSBI($va['cKode'],$va['dTglKegiatan'],$va['optGolonganPSBI'],$va['dTgl'],$va['cNamaKegiatan'],
                                                $va['cPenerimaManfaat'],$va['cTujuanManfaat'],$va['cRuangLingkup'],$va['nPengajuan'],
                                                $va['optLokasiPSBI'],$va['cDetailLokasi'],$va['cPesertaPartisipan'],
                                                $va['cPermasalahan'],$va['cNoSuratProposal'],$va['cJenisBantuan'],
                                                $va['cKodeM02'],$va['dTglM02'],$va['cVendor'],$va['nRealisasi']) ;
        return "OK" ;
    }

    public function deleting($cKode)
    {
        $this->updtransaksi_m->deleteRealisasiPSBI($cKode);
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "psbi_realisasi")){
        $data = $d;
        }
        return $data ;
    }


}