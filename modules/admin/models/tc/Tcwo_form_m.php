<?php 
/**
 * 
 */
class Tcwo_form_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $cUserName  = getsession($this,'username') ;
        $limit      = $va['offset'].",".$va['limit'] ;
        $search	    = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search     = $this->escape_like_str($search) ;
        $where 	    = array() ; 
        $where[]    = "Status <> 'F'";
        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        if(getsession($this,"Jabatan") > "002") $where[] = "TujuanUserName = '$cUserName'";
        $where 	    = implode(" AND ", $where) ;
        $dbd        = $this->select("work_order_master", "*", $where, "", "", "Kode DESC", $limit) ;
        $dba        = $this->select("work_order_master", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getFakturFormWO()
    {
        $dYM            = date('Ym') ;
        $cKey  		    = "FW" . $dYM;
        $n    		    = $this->getincrement($cKey,true,4);
        $cFaktur    	= $cKey . "." . $n ;
        return $cFaktur ;
    }

    public function startWO($cKode,$cFaktur){
        $cUserName = getsession($this,'username') ;
        $dDateTime = date('Y-m-d H:i:s');
        $vaData    = array('Kode'=>$cKode,
                            'Faktur'=>$cFaktur,
                            'Tgl'=>date('Y-m-d'),
                            'StartDateTime'=>$dDateTime,
                            'UserName'=>$cUserName,
                            "Status"=>"1"
                    );
        $vaUpd     = array("StartDateTime"=>$dDateTime);
        $where     = "Kode = ".$this->escape($cKode);

        $this->insert("work_order_form",$vaData);                   // insert data mutasi WO ke work_order_form
        $this->update("work_order_master",$vaUpd,$where,"");        // update StartDate master WO
        $this->updateStatusWO($cKode,"1");                          // update status master WO

        return $vaData;
    }

    public function saving($va){
        /*
            Kode Status WO
            0 = new
            1 = start / proses
            2 = pending
            3 = reject
            F = finish
        */
        $cKode      = $va['cKode'] ;
        $cFaktur    = $va['cFaktur'];
        $cUserName  = getsession($this,'username') ;
        $cOpsi      = $va['cOpsi'];
        $cStatus    = ($cOpsi == "finish") ? "F" : "2";
        $dDateTime  = date('Y-m-d H:i:s');
        $vaUpd1     = array("Faktur"=>$cFaktur,
                            "Kode"=>$cKode, 
                            "Deskripsi"=>$va['cDeskripsi'],
                            "UserName"=>$cUserName ,
                            "EndDateTime"=>$dDateTime,
                            "Status"=>$cStatus
                            ) ;
        $vaUpd2     = array("FinishDateTime"=>$dDateTime);
        $where1     = "Faktur = ".$this->escape($cFaktur);
        $where2     = "Kode   = ".$this->escape($cKode);

        $this->update("work_order_form",$vaUpd1,$where1,"");                         // update data mutasi WO yg sudah diambil
        if($cStatus == "F")  $this->update("work_order_master",$vaUpd2,$where2,"");  // update FinishDateTime master WO jika status Finish
        $this->updateStatusWO($cKode,$cStatus);                                      // update status master WO
        return $vaUpd1 ;
    }

    public function updateStatusWO($cKode,$cStatus="1")
    {
        $where   = "Kode = ".$this->escape($cKode);
        $this->update("work_order_master",array('Status'=>$cStatus),$where,"");
    }

    public function saveFile($va)
    {
        $cKode          = $va['cKode'] ;
        $cFaktur        = $va['cFaktur'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData = array("Faktur"=>$cFaktur,
                        "Kode"=>$cKode, 
                        "Tgl"=>date('Y-m-d'),
                        "FilePath"=>$va['FilePath'],
                        "UserName"=>$cUserName ,
                        "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Faktur = " . $this->escape($cFaktur) ;
        $this->insert("work_order_form_file", $vaData) ;
    }

    public function deleteFile($va)
    {
        $cFaktur = $va['cFaktur'] ;
        $where   = "Faktur = '$cFaktur'" ;
        $this->delete('work_order_form_file',$where);
    }

    public function getdata($id){
        $cUserName = getsession($this,'username');
        $data      = array() ;
        $where[]   = "Kode = " . $this->escape($id);
        $where[]   = "UserName = '$cUserName'";
        $where 	   = implode(" AND ", $where) ;
        if($d = $this->getval("*", $where, "work_order_form")){
            $data = $d;
        }
        return $data ;
    }

    public function getdataWO($id){
        $cUserName = getsession($this,'username');
        $data      = array() ;
        $where[]   = "Kode = " . $this->escape($id);
        $where 	   = implode(" AND ", $where) ;
        if($d = $this->getval("*", $where, "work_order_master")){
            $data = $d;
        }
        return $data ;
    }

    public function seekKodeWO($search)
    {
        $where     = array() ; 
        $where[]   = "Kode <> ''" ;
        if($search !== "") $where[]   = "(Kode LIKE '%{$search}%' OR Subject LIKE '%{$search}%')" ;
        $where     = implode(" AND ", $where) ;
        $dbd        = $this->select("work_order_master", "Kode,Subject", $where, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function getDataOnProsesWO($cKode)
    {
        $where[]   = "Kode = " . $this->escape($cKode);
        $where[]   = "Status = '1'";
        $where 	   = implode(" AND ", $where) ;
        $dbd       = $this->select("work_order_form", "*", $where, "", "", "StartDateTime DESC","1") ;
        return array("db"=>$dbd) ;        
    }

    public function getKodeWObyFaktur($cFaktur)
    {
        $cKode     = "" ;
        $where     = "Faktur = " . $this->escape($cFaktur);
        $dbd       = $this->select("work_order_form", "*", $where, "") ;
        if($dbr    = $this->getrow($dbd)){
            $cKode = $dbr['Kode'];
        }
        return $cKode ;
    }

   
    public function getFileWO($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("work_order_master_file", $field, $where) ;
        return $dbd;
    }
}

 ?>