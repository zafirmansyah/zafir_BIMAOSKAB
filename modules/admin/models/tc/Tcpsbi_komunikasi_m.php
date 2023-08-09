<?php 


/**
 * 
 */
class Tcpsbi_komunikasi_m extends Bismillah_Model
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
        $dbd        = $this->select("psbi_komunikasi", "*", $where, "", "", "WaktuPelaksanaan DESC", $limit) ;
        $dba        = $this->select("psbi_komunikasi", "ID", $where) ;

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
        $vaArray = array("Kode" =>$va['cKode'] ,
                            "Tgl" =>date_2s($va['dTgl']) ,
                            "NamaProgram" =>$va['cNamaKegiatan'] ,
                            "UnitKerja" =>$va['cUnitKerjaPenyelenggara'] ,
                            "LatarBelakangKegiatan" =>$va['cLatarBelakang'] ,
                            "Tujuan" =>$va['cTujuan'] ,
                            "WaktuPelaksanaan" =>date_2s($va['dTglKegiatan']) ,
                            "Narasumber" =>$va['cNarasumber'] ,
                            "Peserta" =>$va['cPeserta'] ,
                            "Saluran" =>$va['cSaluran'] ,
                            "PersepsiStakeHolder" =>$va['cPersepsiStakeholder'] ,
                            "PenggunaanAnggaran" =>$va['nRealisasi'] ,
                            "DampakOutput" =>$va['cDampakOutput']
                            ) ;
        $this->update("psbi_komunikasi",$vaArray,"Kode = '{$va['cKode']}'");
        return "OK" ;
    }

    public function deleting($cKode)
    {
        $this->delete('psbi_komunikasi',"Kode = '{$cKode}'") ;
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "psbi_komunikasi")){
        $data = $d;
        }
        return $data ;
    }


}