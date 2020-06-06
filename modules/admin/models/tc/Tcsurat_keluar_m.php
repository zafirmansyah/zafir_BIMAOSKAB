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
        $dbd      = $this->select("surat_keluar", "*", $where, "", "", "DateTime DESC, Kode DESC", $limit) ;
        $dba      = $this->select("surat_keluar", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getKodeSurat($cJenisSurat)
    {
        $nYear          = date('Y') ;
        $cKey  		    = "SK" . $cJenisSurat . $nYear;
        $n    		    = $this->getincrement($cKey,true,3);
        $cCIF    	    = $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getNomorSuratKeluar($cJenisSurat,$cSifatSurat)
    {

        /**
         * 
         No. (i)/(ii)/(iii)/(iv)/(v)
            Keterangan : 
            (i) 	:	merujuk pada Tahun Buku
            (ii)	:	merujuk pada Nomor Urut Pencatatan Dokumen
            (iii)	:	merujuk pada Singkatan Satuan Kerja dan/atau Unit Kerja Pencipta Dokumen, yang urutannya dipisahkan dengan tanda strip
            (iv)	:	merujuk pada Singkatan Jenis Dokumen
            (v)	    :	merujuk pada Singkatan Sifat Dokumen 
         */
        $nYear              = date('Y') ;
        $nKodeUnit          = getsession($this,'unit') ;
        $nKodeTahunBuku     = $this->getval("KodeTahunBuku","TahunBuku = '$nYear'","tahun_buku") ;
        $cRubrikUnit        = $this->getval("KodeRubrik","Kode = '$nKodeUnit'","golongan_unit") ;
        $cRubrikJenisDok    = $this->getval("KodeRubrik","Kode = '$cJenisSurat'","jenis_surat") ;
        $cRubrikSifatDok    = $this->getval("KodeRubrik","Kode = '$cSifatSurat'","jenis_sifat_surat") ;
        $cUnique            = $nKodeTahunBuku . "/" . $cRubrikUnit ."/".  $cRubrikJenisDok ."/". $cRubrikSifatDok ;
        $cKey  		        = "SK" . $cUnique;
        $n    		        = $this->getincrement($cKey,true,3);
        $nReturn   	        = $nKodeTahunBuku . "/" . $n . "/" . $cRubrikUnit . "/" . $cRubrikJenisDok . "/" . $cRubrikSifatDok;
        return $nReturn ;
    }

    public function saving($va){
        $cJenisSurat = $va['optJenisSurat'] ;
        $cSifatSurat = $va['optSifatSurat'];
        $cFaktur     = $this->getKodeSurat($cJenisSurat) ;
        $nNomorSurat = $this->getNomorSuratKeluar($cJenisSurat,$cSifatSurat) ;
        $vaData     = array("Kode"=>$cFaktur, 
                            "Kepada"=>$va['cKepada'],
                            "Perihal"=>$va['cPerihal'],
                            "Tgl"=>date_2s($va['dTgl']),
                            "NoSurat"=>$nNomorSurat,
                            "JenisSurat"=>$cJenisSurat,
                            "Unit"=>getsession($this,'unit'),
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

    public function SeekSifatSurat($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("jenis_sifat_surat", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

}

 ?>