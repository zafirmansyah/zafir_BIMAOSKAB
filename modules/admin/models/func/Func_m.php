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

    public function getNomorRubrikSurat($nYear,$cKodeUnit,$cRubrikJenisDok,$cSifatSurat,$cUniqueKey='BIMAOSKAB',$lUpdate=true)
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
         * @param   string $cUniqueKey berisi tentang kode inisial yang ingin digunakan `SK = Surat Keluar ; SM = Surat Masuk ; M02 = Memorandum`
         */
        $nKodeTahunBuku     = $this->getval("KodeTahunBuku","TahunBuku = '$nYear'","tahun_buku") ;
        
        $cRubrikUnit        = $this->getval("KodeRubrik","Kode = '$cKodeUnit'","golongan_unit") ;
        $cRubrikSifatDok    = $this->getval("KodeRubrik","Kode = '$cSifatSurat'","jenis_sifat_surat") ;
        $cUnique            = $nKodeTahunBuku . "/" . $cRubrikUnit ."/".  $cRubrikJenisDok ."/". $cRubrikSifatDok ;
        $cKey  		        = $cUniqueKey . $cUnique;
        $n    		        = $this->getincrement($cKey,$lUpdate,1);
        $nReturn   	        = $nKodeTahunBuku . "/" . $n . "/" . $cRubrikUnit . "/" . $cRubrikJenisDok . "/" . $cRubrikSifatDok;
        return $nReturn ;
    }

}
?>