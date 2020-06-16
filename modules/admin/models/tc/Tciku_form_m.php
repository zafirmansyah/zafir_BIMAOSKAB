<?php 
/**
 * 
 */
class Tciku_form_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	 = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $where 	 = array() ; 
        if($search !== "") $where[]	= "(Kode LIKE '{$search}%' OR Perihal LIKE '%{$search}%')" ;
        $where 	 = implode(" AND ", $where) ;
        $dbd      = $this->select("iku_master", "*", $where, "", "", "Kode DESC", $limit) ;
        $dba      = $this->select("iku_master", "ID", $where) ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }
    
    public function getKodeIKU()
    {
        $dYM        = date('Ym') ;
        $cKey  		= "IKU" . $dYM;
        $n    		= $this->getincrement($cKey,true,3);
        $cCIF    	= $cKey . "." . $n ;
        return $cCIF ;
    }

    public function saving($va){

        //var_dump($va);    
        $cKode = $va['cKode'] ;
        $cUserName                 = getsession($this,'username') ;
        
        $this->delete("iku_form", "Kode = '{$cKode}' and UserName = '{$cUserName}'" ) ;
        $vaData         = array("Kode"=>$cKode, 
                                "Tgl"=>date_2s($va['dTgl']),
                                "Deskripsi"=>$va['cDeskripsi'],
                                "UserName"=>$cUserName ,
                                "DateTime"=>date('Y-m-d H:i:s')
                                ) ;
        $this->insert("iku_form",$vaData);
        
        return $vaData ;
    }

    public function saveFile($va)
    {
        $cKode          = $va['cKode'] ;
        $cUserName      = getsession($this,'username') ;
        $vaData = array("Kode"=>$cKode, 
                        "Tgl"=>date_2s($va['dTgl']),
                        "FilePath"=>$va['FilePath'],
                        "UserName"=>$cUserName ,
                        "DateTime"=>date('Y-m-d H:i:s')
        ) ;
        $where      = "Kode = " . $this->escape($cKode) ;
        $this->insert("iku_form_file", $vaData, $where, "") ;
    }

    public function deleteFile($va)
    {
        $cKode  = $va['cKode'] ;
        $cWhere = "Kode = '$cKode'" ;
        $this->delete('iku_form_file',$cWhere);
    }

    public function getdata($id){
        $cUserName = getsession($this,'username');
        $data = array() ;
        if($d = $this->getval("*", "Kode = " . $this->escape($id) . "AND UserName='$cUserName'", "iku_form")){
        $data = $d;
        }
        return $data ;
    }

    public function deleting($id){
        $this->delete("iku_form", "Kode = " . $this->escape($id)) ;
    }

    public function seekKodeIKU($search)
    {
        $cWhere     = array() ; 
        $cWhere[]   = "Kode <> ''" ;
        if($search !== "") $cWhere[]   = "(Kode LIKE '%{$search}%' OR Subject LIKE '%{$search}%')" ;
        $cWhere     = implode(" AND ", $cWhere) ;
        $dbd        = $this->select("iku_master", "Kode,Subject", $cWhere, "", "", "Kode ASC") ;
        return array("db"=>$dbd) ;
    }

    public function getDataTargetDisposisi($cKode)
    {
        $data = array() ;
		if($d = $this->getval("*", "KodeKaryawan = " . $this->escape($cKode), "sys_username")){
            $data = $d;
		}
		return $data ;
    }
}

 ?>