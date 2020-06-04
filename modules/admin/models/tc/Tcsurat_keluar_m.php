<?php 


/**
 * 
 */
class Tcsurat_keluar_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        if($search !== "") $where[]	= "(kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $dbd      = $this->select("surat_keluar", "*", $where, "", "", "kode ASC", $limit) ;
        $dba      = $this->select("surat_keluar", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getKodeSurat($cJenisSurat)
    {
        $nYear      = date('Y') ;
        $cKey  		= "SK" . $cJenisSurat . $nYear;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getNomorSuratKeluar($cJenisSurat)
    {
        $nReturn = 1 ;
        $cTable  = "surat_keluar" ;
        $cField  = "NoSurat" ;
        $cWhere  = "JenisSurat = '$cJenisSurat'" ;
        $cOrder  = "Tgl DESC" ;
        $nLimit  = "0,1" ;
        $dbData  = $this->select($cTable,$cField,$cWhere,"","",$cOrder,$nLimit) ;
        if($dbRow = $this->getrow($dbData)){
            $nReturn = $dbRow['NoSurat'] + 1 ;
        }
        return $nReturn ;
    }

    public function saving($va){
        $cJenisSurat = $va['optJenisSurat'] ;
        $cFaktur     = $this->getKodeSurat($cJenisSurat) ;
        $nNomorSurat = $this->getNomorSuratKeluar($cJenisSurat) ;
        $vaData     = array("Kode"=>$cFaktur, 
                            "Kepada"=>$va['cKepada'],
                            "Perihal"=>$va['cPerihal'],
                            "Tgl"=>date_2s($va['dTgl']),
                            "NoSurat"=>$nNomorSurat,
                            "JenisSurat"=>$cJenisSurat,
                            "Unit"=>"",
                            "UserName"=>getsession($this,'username'),
                            "DateTime"=>date('Y-m-d H:i:s')
                            ) ;
        $where      = "Kode = " . $this->escape($cFaktur) ;
        $this->update("surat_keluar", $vaData, $where, "") ;
        return $vaData ;
    }

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_keluar")){
        $data = $d;
        }
        return $data ;
    }

    public function deleting($id){
        $this->delete("surat_keluar", "Kode = " . $this->escape($id)) ;
    }

    public function getIncreamentKode()
    {
        $cKey  		= "mstsurat_keluar_" ;
        $n    		= $this->getincrement($cKey,true,3);
        $cKode    = $n ;
        return $cKode ;
    }

    public function SeekJenisSurat($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("jenis_surat", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

}

 ?>