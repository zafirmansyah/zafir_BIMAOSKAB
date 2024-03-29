<?php 


/**
 * 
 */
class Tcsurat_keluar_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        
        /**
            NoSurat
            Perihal
            Kepada
            JenisSurat
            UserName
            Unit
            Tgl 
        */
        
        $searchField	 = isset($va['search'][0]['field']) ? $va['search'][0]['field'] : "" ;
        $searchValue	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $searchField     = $this->escape_like_str($searchField) ;
        $searchValue     = $this->escape_like_str($searchValue) ;

        $where 	    = array() ; 
        $where[]    = "Status = '1'" ;
        if($searchValue !== "") $where[]	= "{$searchField} LIKE '%{$searchValue}%'" ; 
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("surat_keluar", "*", $where, "", "", "DateTime DESC, Kode DESC", $limit) ;
        $dba        = $this->select("surat_keluar", "ID", $where) ;

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

    public function getNomorSuratKeluar($cJenisSurat,$cSifatSurat,$lUpdate=true)
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
        $n    		        = $this->getincrement($cKey,$lUpdate,1);
        $nReturn   	        = $nKodeTahunBuku . "/" . $n . "/" . $cRubrikUnit . "/" . $cRubrikJenisDok . "/" . $cRubrikSifatDok;
        return $nReturn ;
    }

    public function saving($va){
        $cJenisSurat        = $va['optJenisSurat'] ;
        $cSifatSurat        = $va['optSifatSurat'];
        $cKodeUnit          = $va['optUnit'] ;
        $cSifatSurat        = $va['optSifatSurat'];
        $dTgl               = date_2s($va['dTgl']) ;
        $nYear              = substr($dTgl,0,4) ;
        $cFaktur            = $this->getKodeSurat($cJenisSurat) ;
        $nNomorSurat        = $this->func->getNomorRubrikSurat($nYear,$cKodeUnit,$cJenisSurat,$cSifatSurat,'SK',true) ;
        $vaData     = array("Kode"       =>$cFaktur, 
                            "Kepada"     => $va['cKepada'],
                            "Perihal"    => $va['cPerihal'],
                            "Tgl"        => date_2s($va['dTgl']),
                            "NoSurat"    => $nNomorSurat,
                            "JenisSurat" => $cJenisSurat,
                            "Unit"       => getsession($this,'unit'),
                            "UserName"   => getsession($this,'username'),
                            "DateTime"   => date('Y-m-d H:i:s')
                            ) ;
        $where      = "Kode = " . $this->escape($cFaktur) ;
        $this->update("surat_keluar", $vaData, $where, "") ;
        return $vaData ;
    }

    public function checkNomorSurat($va)
    {
        $cJenisSurat        = $va['optJenisSurat'] ;
        $cSifatSurat        = $va['optSifatSurat'];
        $cKodeUnit          = $va['optUnit'] ;
        $cSifatSurat        = $va['optSifatSurat'];
        $dTgl               = date_2s($va['dTgl']) ;
        $nYear              = substr($dTgl,0,4) ;
        $nNomorSurat = $this->func->getNomorRubrikSurat($nYear,$cKodeUnit,$cJenisSurat,$cSifatSurat,'SK',false) ;
        // $nNomorSurat = $this->getNomorSuratKeluar($cJenisSurat,$cSifatSurat,false) ;
        return $nNomorSurat ;
    } 

    public function getdata($id){
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id), "surat_keluar")){
        $data = $d;
        }
        return $data ;
    }

    public function deleting($id){
        $cWhere = "Kode = " . $this->escape($id);
        $cTable = "surat_keluar";
        $vaUpdate = array("Status"=>'0');
        $this->Update($cTable,$vaUpdate,$cWhere,"") ;
        // $this->delete("surat_keluar", "Kode = " . $this->escape($id)) ;
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
        $cWhere[]   = "Kode <> '006'" ;
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

    public function seekUnit($search)
    {   
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> '' OR Kode <> '000'" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Keterangan LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("golongan_unit", "Kode,Keterangan", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

}

 ?>