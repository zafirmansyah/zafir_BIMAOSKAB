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
    
    public function getJumlahSuratMasuk()
    {
        $nJumlah   = 0;
        $field     = "COUNT(s.ID) Jml";
        $join      = "left join surat_masuk_disposisi d on d.Kode=s.Kode";
        $dbd       = $this->select("surat_masuk s", "s.*,d.*", "", $join, "s.Kode", "s.Kode DESC", "") ;
        $nJumlah   = $this->rows($dbd);
        return $nJumlah;
    }


    public function getJumlahSuratMasukPerUser()
    {
        $nJumlah   = 0;
        $cUser     = getsession($this,"KodeKaryawan");
        $field     = "COUNT(s.ID) Jml";
        $where     = "d.Terdisposisi = '$cUser'";
        $join      = "left join surat_masuk_disposisi d on d.Kode=s.Kode";
        $dbd       = $this->select("surat_masuk s", "s.*,d.*", $where, $join, "s.Kode", "s.Kode DESC", "") ;
        $nJumlah   = $this->rows($dbd);
        return $nJumlah;
    }

    public function getJumlahM02()
    {
        $nJumlah   = 0;
        $where     = "Status = '1'";
        $dbd       = $this->select("m02_prinsip", "*", $where, "", "", "", "") ;
        $nJumlah   = $this->rows($dbd);
        return $nJumlah;
    }

    public function getJumlahIKU()
    {
        $nJumlah    = 0;
        $where 	    = array() ; 
        $where      = "Status <> 0";
        $dbd        = $this->select("iku_master", "*", $where, "", "", "", "") ;
        $nJumlah    = $this->rows($dbd);
        return $nJumlah;
    }

    public function getJumlahIKUPerUnit()
    {
        $nJumlah    = 0;
        $cUnitUser  = getsession($this,"unit");
        $where 	    = array() ; 
        $where[]    = "Status <> 0";
        if(getsession($this,"Jabatan") > "002") $where[] = "TujuanUnit = '$cUnitUser'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("iku_master", "*", $where, "", "", "", "") ;
        $nJumlah    = $this->rows($dbd);
        return $nJumlah;
    }

    public function getJumlahWO()
    {
        $nJumlah    = 0;
        $where      = "Status <> 'F' AND Status <> 'D'";
        $dbd        = $this->select("work_order_master", "*", $where, "", "", "","") ;
        while($dbr  = $this->getrow($dbd)){
            $nJumlah++;
        }        
        return $nJumlah;
    }

    public function getJumlahWOPerUnit()
    {
        $cUnit      = getsession($this,"unit");
        $nJumlah    = 0;
        $where      = "Status <> 'F' AND Status <> 'D'";
        $dbd        = $this->select("work_order_master", "*", $where, "", "", "","") ;
        while($dbr  = $this->getrow($dbd)){
            $cUserTujuan            = $dbr['TujuanUserName'];
            $vaDataUserTujuan       = $this->geDataUser($cUserTujuan);
            $cUnitUserTujuan        = $vaDataUserTujuan['Unit'];
            if($cUnitUserTujuan == $cUnit){
                $nJumlah++;
            }
        }        
        return $nJumlah;
    }

    public function getDataWOPerUser()
    {
        $cUserName = getsession($this,"username");
        $vaData    = array();
        $limit     = "0,10";
        if(getsession($this,"Jabatan") > "002") $where[] = "m.TujuanUserName = '$cUserName'";        
        $where[]   = "m.Status <> 'D'";
        $where 	   = implode(" AND ", $where) ;
        $dbd       = $this->select("work_order_master m", "m.*", $where, "", "m.Kode", "m.Tgl DESC", $limit) ;
        while($dbr = $this->getrow($dbd)){
            $vaData[] = $dbr;
        }
        return $vaData;
    }

    public function getDataIKUPerUnit()
    {
        $cUnitUser  = getsession($this,"unit");
        $where 	    = array() ; 
        $limit     = "0,10";
        $where[]    = "Status <> 0";
        if(getsession($this,"Jabatan") > "002") $where[] = "TujuanUnit = '$cUnitUser'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("iku_master", "*", $where, "", "", "Kode DESC", $limit) ;
        while($dbr = $this->getrow($dbd)){
            $vaData[] = $dbr;
        }
        return $vaData;
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

    public function geDataUser($cUserName)
    {
        $field = "*";
        $where = "UserName = '$cUserName'";
        $dbd   = $this->select("sys_username", $field, $where) ;
        $vaData = array();
        if($dbr = $this->getrow($dbd)){
            $vaData = $dbr;
        }
        return $vaData;
    }
}
?>