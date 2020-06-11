<?php

class Tcm_prinsip_m extends Bismillah_Model
{
    public function getKodeSurat()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "M02P" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function getNomorSurat($cSifatSurat)
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
        $cRubrikJenisDok    = "M.02" ;
        $cRubrikSifatDok    = $this->getval("KodeRubrik","Kode = '$cSifatSurat'","jenis_sifat_surat") ;
        $cUnique            = $nKodeTahunBuku . "/" . $cRubrikUnit ."/".  $cRubrikJenisDok ."/". $cRubrikSifatDok ;
        $cKey  		        = "M02P" . $cUnique;
        $n    		        = $this->getincrement($cKey,true,3);
        $nReturn   	        = $nKodeTahunBuku . "/" . $n . "/" . $cRubrikUnit . "/" . $cRubrikJenisDok . "/" . $cRubrikSifatDok;
        return $nReturn ;
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

    public function loadgrid($va){
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        if($search !== "") $where[]	= "(Faktur LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("m02_prinsip", "*", $where, "", "", "Tgl DESC,Faktur ASC", $limit) ;
        $dba        = $this->select("m02_prinsip", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function saveData($va)
    {
        $cUserName  = getsession($this,'username') ;
        $vaData     = array("Faktur"=>$va['cFaktur'],
                            "Kepada"=>$va['cKepada'],
                            "Perihal"=>$va['cSubject'],
                            "Keterangan"=>$va['cDeskripsi'],
                            "Metode"=>$va['optMetode'],
                            "Tgl"=>date_2s($va['dTgl']),
                            "NoSurat"=>$va['cNoSurat'],
                            "StatusPersetujuan"=>"0",
                            "Sifat"=>$va['optSifatSurat'],
                            "Status"=>"1",
                            "UserName"=>$cUserName,
                            "DateTime"=>date("Y-m-d H:i:s"));
        $where      = "Faktur = " . $this->escape($va['cFaktur']) ;
        $this->update("m02_prinsip", $vaData, $where, "") ;

        $vaGrid = json_decode($va['dataDetailprinsip']);
        $this->delete("m02_prinsip_detail", "Faktur = '{$va['cFaktur']}'" ) ;
        foreach($vaGrid as $key => $val){
            $where      = "Faktur = " . $this->escape($va['cFaktur']) ;
            $vadetail   = array("Faktur"=>$va['cFaktur'],
                                "Tgl"=>date_2s($va['dTgl']),
                                "Keterangan"=>$val->Keterangan,
                                "Nominal"=>$val->Nominal,
                                "UserName"=>$cUserName,
                                "DateTime"=>date('Y-m-d H:i:s'));
            $this->insert("m02_prinsip_detail",$vadetail);
        }
        return "OK" ;

    }
}


?>